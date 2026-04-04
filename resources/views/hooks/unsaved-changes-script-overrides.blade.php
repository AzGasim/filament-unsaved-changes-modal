@php
    $unsavedBody = __('filament-panels::unsaved-changes-alert.body');
    $modalId = \AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin::MODAL_DOM_ID;
@endphp

@script
    <script>
        ;(function () {
            const modalId = @js($modalId)

            function buildApi({ $wire, bodyText, spaMode, resolveLivewireComponentUsing }) {
                function shouldPreventNavigation() {
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
                        window.jsMd5(JSON.stringify($wire.data).replace(/\\/g, '')) !== hash
                    )
                }

                let pendingHref = null
                let bypassBeforeUnloadOnce = false
                let bypassNavigatePromptOnce = false

                function openModal() {
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

                function closeModal() {
                    document.dispatchEvent(
                        new CustomEvent('close-modal', {
                            bubbles: true,
                            composed: true,
                            detail: { id: modalId },
                        }),
                    )
                }

                window.filamentUnsavedChangesModal = {
                    stay() {
                        pendingHref = null
                        closeModal()
                    },
                    leave() {
                        const href = pendingHref
                        pendingHref = null
                        closeModal()
                        if (! href) {
                            return
                        }
                        bypassBeforeUnloadOnce = true
                        if (
                            spaMode &&
                            window.Alpine &&
                            typeof window.Alpine.navigate === 'function'
                        ) {
                            bypassNavigatePromptOnce = true
                            window.Alpine.navigate(href)
                        } else {
                            window.setTimeout(() => window.location.assign(href), 0)
                        }
                    },
                }

                function hrefFromNavigateDetail(detail) {
                    const url = detail?.url
                    if (! url) {
                        return null
                    }
                    if (url instanceof URL) {
                        return url.href
                    }
                    try {
                        return new URL(String(url), window.location.href).href
                    } catch {
                        return null
                    }
                }

                function isDangerousHrefAttribute(hrefAttr) {
                    const lower = hrefAttr.trim().toLowerCase()
                    return (
                        lower.startsWith('javascript:') ||
                        lower.startsWith('vbscript:') ||
                        lower.startsWith('data:')
                    )
                }

                function isAllowedHttpNavigation(url) {
                    return url.protocol === 'http:' || url.protocol === 'https:'
                }

                if (spaMode) {
                    let pendingSkipNavigateHref = null

                    document.addEventListener(
                        'click',
                        function (event) {
                            if (event.defaultPrevented || event.button !== 0) {
                                pendingSkipNavigateHref = null

                                return
                            }
                            if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                                pendingSkipNavigateHref = null

                                return
                            }

                            const anchor = event.target.closest('a[href]')
                            if (! anchor) {
                                pendingSkipNavigateHref = null

                                return
                            }
                            if (! anchor.closest('[data-skip-unsaved-changes-modal]')) {
                                pendingSkipNavigateHref = null

                                return
                            }
                            if (anchor.getAttribute('target') === '_blank' || anchor.hasAttribute('download')) {
                                pendingSkipNavigateHref = null

                                return
                            }

                            const hrefAttr = anchor.getAttribute('href')
                            if (! hrefAttr || hrefAttr.startsWith('#')) {
                                pendingSkipNavigateHref = null

                                return
                            }
                            if (isDangerousHrefAttribute(hrefAttr)) {
                                pendingSkipNavigateHref = null

                                return
                            }
                            if (! anchor.closest('.fi-body')) {
                                pendingSkipNavigateHref = null

                                return
                            }

                            let nextUrl
                            try {
                                nextUrl = new URL(anchor.href)
                            } catch {
                                pendingSkipNavigateHref = null

                                return
                            }

                            if (! isAllowedHttpNavigation(nextUrl)) {
                                pendingSkipNavigateHref = null

                                return
                            }
                            if (nextUrl.origin !== window.location.origin) {
                                pendingSkipNavigateHref = null

                                return
                            }

                            pendingSkipNavigateHref = nextUrl.href
                        },
                        true,
                    )

                    document.addEventListener('livewire:navigate', function (event) {
                        try {
                            if (typeof resolveLivewireComponentUsing() === 'undefined') {
                                return
                            }
                        } catch {
                            return
                        }

                        if (bypassNavigatePromptOnce) {
                            bypassNavigatePromptOnce = false

                            return
                        }

                        const href = hrefFromNavigateDetail(event.detail)
                        const skipForHref = pendingSkipNavigateHref
                        pendingSkipNavigateHref = null

                        if (skipForHref && href && skipForHref === href) {
                            return
                        }

                        if (! shouldPreventNavigation()) {
                            return
                        }

                        if (! href) {
                            return
                        }

                        let nextUrl
                        try {
                            nextUrl = new URL(href)
                        } catch {
                            return
                        }

                        if (! isAllowedHttpNavigation(nextUrl)) {
                            return
                        }

                        if (nextUrl.origin !== window.location.origin) {
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
                            if (event.defaultPrevented || event.button !== 0) {
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
                            if (! hrefAttr || hrefAttr.startsWith('#')) {
                                return
                            }
                            if (isDangerousHrefAttribute(hrefAttr)) {
                                return
                            }

                            if (! anchor.closest('.fi-body')) {
                                return
                            }

                            let nextUrl
                            try {
                                nextUrl = new URL(anchor.href)
                            } catch {
                                return
                            }

                            if (! isAllowedHttpNavigation(nextUrl)) {
                                return
                            }

                            if (nextUrl.origin !== window.location.origin) {
                                return
                            }

                            if (nextUrl.href === window.location.href) {
                                return
                            }

                            if (! shouldPreventNavigation()) {
                                return
                            }

                            event.preventDefault()
                            pendingHref = nextUrl.href
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
