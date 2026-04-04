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

                return (
                    window.jsMd5(JSON.stringify($wire.data).replace(/\\/g, '')) !==
                    $wire.savedDataHash
                )
            }

            let pendingNavigation = null

            const uriFromNavigateDetail = (detail) => {
                const url = detail?.url
                if (! url) {
                    return null
                }
                if (url instanceof URL) {
                    return url.pathname + url.search + url.hash
                }

                return String(url)
            }

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

            window.filamentUnsavedChangesModalSpa = {
                stay() {
                    pendingNavigation = null
                    closeModal()
                },
                leave() {
                    const target = pendingNavigation
                    pendingNavigation = null
                    closeModal()
                    if (! target?.uri || ! window.Alpine?.navigate) {
                        return
                    }

                    queueMicrotask(() => {
                        window.Alpine.navigate(target.uri, {
                            preserveScroll: target.preserveScroll ?? false,
                        })
                    })
                },
            }

            document.addEventListener('livewire:navigate', (event) => {
                if (typeof resolveLivewireComponentUsing() === 'undefined') {
                    return
                }

                if (! shouldPreventNavigation()) {
                    return
                }

                event.preventDefault()

                pendingNavigation = {
                    uri: uriFromNavigateDetail(event.detail),
                    preserveScroll: event.detail?.preserveScroll ?? false,
                }

                openModal()
            })

            window.addEventListener('beforeunload', (event) => {
                if (! shouldPreventNavigation()) {
                    return
                }

                event.preventDefault()
                event.returnValue = true
            })
        }
    </script>
@endscript
