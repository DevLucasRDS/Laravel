@if(session()->has('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            title: "{{ session('success') }}",
            icon: "success",
        });
    })
</script>
@endif

@if ($errors->any())
@php
$mensagem = '';
foreach ($errors->all() as $error) {
$mensagem .= $error . '<br>';
}
@endphp

<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            title: "Oops...",
            html: "{!! $mensagem !!}",
            icon: "error",
        });
    })
</script>
@endif