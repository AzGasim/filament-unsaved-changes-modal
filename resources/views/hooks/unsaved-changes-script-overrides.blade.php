@php
    $unsavedBody = __('filament-panels::unsaved-changes-alert.body');
@endphp

@script
    <script>
        ;(function () {
            const modalId = @js(config('unsaved-changes-modal.spa_navigation_modal_id'))

            function buildApi({
                $wire,
                bodyText,
                spaMode,
                resolveLivewireComponentUsing,
            }) {
                const shouldPreventNavigation = function () {
                    if ($wire?.__instance?.effects?.redirect) {
                        return false
                    }

                    const hash = $wire?.savedDataHash
                    if (hash == null || hash === '') {
                        return false
                    }

                    if ($wire?.data === undefined) {
                        return false
                    }

                    return (
                        window.jsMd5(JSON.stringify($wire.data).replace(/\\/g, '')) !==
                        hash
                    )
                }

                let pendingHref = null

                /** Skip the next beforeunload prompt (user already confirmed in our modal). */
                let bypassBeforeUnloadOnce = false

                /** Skip one livewire:navigate interception after user confirmed (SPA). */
                let bypassNavigatePromptOnce = false

                const openModal = function () {
                    const root = document.getElementById(modalId)
                    const desc = root?.querySelector('.fi-modal-description')
                    if (desc && bodyText) {
                        desc.textContent = bodyText
                    }

                    document.dispatchEvent(
                        new CustomEvent('open-modal', {
                            bubbles: true,
                            composed: true,
                            detail: { id: modalId },
                        }),
                    )
                }

                const closeModal = function () {
                    document.dispatchEvent(
                        new CustomEvent('close-modal', {
                            bubbles: true,
                            composed: true,
                            detail: { id: modalId },
                        }),
                    )
                }

                window.filamentUnsavedChangesModal = {
                    stay: function () {
                        pendingHref = null
                        closeModal()
                    },
                    leave: function () {
                        const href = pendingHref
                        pendingHref = null
                        closeModal()
                        if (! href) {
                            return
                        }
                        bypassBeforeUnloadOnce = true
                        if (spaMode && window.Alpine && typeof window.Alpine.navigate === 'function') {
                            bypassNavigatePromptOnce = true
                            window.Alpine.navigate(href)
                        } else {
                            window.setTimeout(function () {
                                window.location.assign(href)
                            }, 0)
                        }
                    },
                }

                const hrefFromNavigateDetail = function (detail) {
                    const url = detail && detail.url
                    if (! url) {
                        return null
                    }
                    if (url instanceof URL) {
                        return url.href
                    }
                    try {
                        return new URL(String(url), window.location.href).href
                    } catch (e) {
                        return null
                    }
                }

                if (spaMode) {
                    document.addEventListener('livewire:navigate', function (event) {
                        if (typeof resolveLivewireComponentUsing() === 'undefined') {
                            return
                        }

                        if (bypassNavigatePromptOnce) {
                            bypassNavigatePromptOnce = false

                            return
                        }

                        if (! shouldPreventNavigation()) {
                            return
                        }

                        const href = hrefFromNavigateDetail(event.detail)
                        if (! href) {
                            return
                        }

                        event.preventDefault()

                        pendingHref = href
                        openModal()
                    })
                } else {
                    document.addEventListener(
                        'click',
                        function (event) {
                            if (event.defaultPrevented) {
                                return
                            }
                            if (event.button !== 0) {
                                return
                            }
                            if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                                return
                            }

                            const anchor = event.target.closest('a[href]')
                            if (! anchor) {
                                return
                            }
                            if (anchor.closest('[data-skip-unsaved-changes-modal]')) {
                                return
                            }
                            if (anchor.getAttribute('target') === '_blank') {
                                return
                            }
                            if (anchor.hasAttribute('download')) {
                                return
                            }

                            const hrefAttr = anchor.getAttribute('href')
                            if (
                                ! hrefAttr ||
                                hrefAttr.startsWith('#') ||
                                hrefAttr.startsWith('javascript:')
                            ) {
                                return
                            }

                            if (! anchor.closest('.fi-body')) {
                                return
                            }

                            let absoluteHref
                            try {
                                absoluteHref = new URL(anchor.href).href
                            } catch (e) {
                                return
                            }

                            if (absoluteHref === window.location.href) {
                                return
                            }

                            const nextUrl = new URL(absoluteHref)
                            if (nextUrl.origin !== window.location.origin) {
                                return
                            }

                            if (! shouldPreventNavigation()) {
                                return
                            }

                            event.preventDefault()
                            pendingHref = absoluteHref
                            openModal()
                        },
                        true,
                    )
                }

                window.addEventListener('beforeunload', function (event) {
                    if (bypassBeforeUnloadOnce) {
                        bypassBeforeUnloadOnce = false

                        return
                    }

                    if (! shouldPreventNavigation()) {
                        return
                    }

                    event.preventDefault()
                    event.returnValue = true
                })
            }

            window.setUpSpaModeUnsavedDataChangesAlert = function ({
                body,
                resolveLivewireComponentUsing,
                $wire,
            }) {
                buildApi({
                    $wire,
                    bodyText: body,
                    spaMode: true,
                    resolveLivewireComponentUsing,
                })
            }

            window.setUpUnsavedDataChangesAlert = function ({ $wire }) {
                buildApi({
                    $wire,
                    bodyText: @js($unsavedBody),
                    spaMode: false,
                    resolveLivewireComponentUsing: () => undefined,
                })
            }
        })()
    </script>
@endscript
