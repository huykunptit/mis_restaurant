@if (session('error'))

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
            showCloseButton: true
        })
    </script>

@elseif (session('success'))

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            showCloseButton: true
        })
    </script>

@endif

{{-- Livewire Toast Notifications --}}
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('flashMessage', message => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: message,
                showCloseButton: true
            })
        })

        Livewire.on('flashError', message => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast'
                },
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: message,
                showCloseButton: true
            })
        })
    })
</script>

