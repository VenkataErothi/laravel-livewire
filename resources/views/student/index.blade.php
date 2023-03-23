@extends('layouts.app')

@section('content')

    <div>
       <livewire:student-show>
    </div>

@endsection
@section('script')
@livewireScripts
<script>
    window.livewire.on('studentSave',() => {

        $('#studentModal').modal('hide');
    })
    window.livewire.on('studentUpdate',() => {

        $('#updateStudentModal').modal('hide');
        })
    window.livewire.on('studentDestroy',() => {

        $('#deleteStudentModal').modal('hide');
        })
   
</script>
@endsection

