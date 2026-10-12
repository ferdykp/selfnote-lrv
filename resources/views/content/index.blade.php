@extends('layouts.master')
@section('page_label', 'Semua catatan')
@section('content')
<section class="page-container">
    @include('content.partials.toast-container')
    @include('content.partials.filter-bar')
    <div id="notesContainer" class="notes-grid" aria-live="polite">
        @forelse($contents as $note)
            @include('content.partials.note-card', ['note'=>$note])
        @empty
            <div class="empty-state"><span class="empty-icon"><i class="fa-regular fa-pen-to-square"></i></span><h3>Mulai dari satu ide kecil.</h3><p>Belum ada catatan di sini. Tulis sesuatu yang ingin kamu ingat.</p><a class="primary-button" href="{{ route('content.create') }}"><i class="fa-solid fa-plus"></i> Tulis catatan pertama</a></div>
        @endforelse
    </div>
    @include('content.partials.confirm-modal')
</section>
@endsection
@push('scripts')
<script>
let pendingDeleteForm = null;
function openConfirmModal(event,button){event.stopPropagation();pendingDeleteForm=button.closest('form');const modal=document.getElementById('confirmModal');modal?.classList.remove('hidden');modal?.classList.add('flex');}
function closeConfirmModal(){const modal=document.getElementById('confirmModal');modal?.classList.add('hidden');modal?.classList.remove('flex');pendingDeleteForm=null;}
document.getElementById('confirmDeleteBtn')?.addEventListener('click',()=>pendingDeleteForm?.submit());
</script>
@endpush
