<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h4 class="m-0 font-weight-bold text-danger">Dashboard</h4>
    </div>
    @include('dashboard.components.body')
    @include('dashboard.components.grafik')
    
    

    

</x-layout>
