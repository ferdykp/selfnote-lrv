@extends('layouts.master')
@section('page_label', 'Riwayat revisi')
@section('content')
<section class="page-container"><div class="page-intro"><div><h1>Riwayat revisi<span class="accent-dot">.</span></h1><p>{{ $note->title }} — maksimal 30 versi terakhir sebelum perubahan.</p></div><a href="{{ route('content.edit',$note) }}" class="primary-button">Kembali ke editor</a></div>
@forelse($revisions as $revision)
<article class="revision-card"><div><strong>{{ $revision->created_at->format('d M Y H:i') }}</strong><p>{{ $revision->title }} · {{ $revision->status }}</p><p>{{ \Illuminate\Support\Str::limit(strip_tags($revision->content),180) }}</p></div><form action="{{ route('content.revisions.restore',[$note,$revision]) }}" method="POST">@csrf<button class="primary-button" type="submit">Pulihkan versi ini</button></form></article>
@empty <div class="empty-state"><h3>Belum ada revisi</h3><p>Riwayat dibuat saat catatan tersimpan setelah berubah.</p></div> @endforelse
</section>
@endsection
