@script
    <script>
        window.setUpSpaModeUnsavedDataChangesAlert = function ({
            body,
            resolveLivewireComponentUsing,
            $wire,
        }) {
            const modalId = @js(config('unsaved-changes-modal.spa_navigation_modal_id'))

            const shouldPreventNavigation = () => {
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

            /** Skip the next beforeunload prompt (user already confirmed in our modal). */
            let bypassBeforeUnloadOnce = false

            const openModal = () => {
                const root = document.getElementById(modalId)
                const desc = root?.querySelector('.fi-modal-description')
                if (desc && body) {
                    desc.textContent = body
                }

                document.dispatchEvent(
                    new CustomEvent('open-modal', {
                        bubbles: true,
                        composed: true,
                        detail: { id: modalId },
                    }),
                )
            }

            const closeModal = () => {
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
                    window.setTimeout(function () {
                        window.location.assign(href)
                    }, 0)
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

            document.addEventListener('livewire:navigate', function (event) {
                if (typeof resolveLivewireComponentUsing() === 'undefined') {
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
    </script>
@endscript
