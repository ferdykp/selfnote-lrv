<script>
(() => {
  const root=document.documentElement;
  const toggle=document.getElementById('themeToggle');const mobileThemeToggle=document.getElementById('mobileThemeToggle');
  function syncTheme(){const dark=root.classList.contains('dark');document.getElementById('themeIcon')?.classList.toggle('fa-sun',dark);document.getElementById('themeIcon')?.classList.toggle('fa-moon',!dark);const label=document.getElementById('themeLabel');if(label)label.textContent=dark?'Mode terang':'Mode gelap';const icon=document.getElementById('mobileThemeIcon');icon?.classList.toggle('fa-sun',dark);icon?.classList.toggle('fa-moon',!dark);mobileThemeToggle?.setAttribute('aria-pressed',String(dark));}
  function switchTheme(){root.classList.toggle('dark');try{localStorage.setItem('theme',root.classList.contains('dark')?'dark':'light')}catch(e){}syncTheme()}
  syncTheme();toggle?.addEventListener('click',switchTheme);mobileThemeToggle?.addEventListener('click',switchTheme);
  document.addEventListener('keydown',e=>{if(e.key==='/'&&!['INPUT','TEXTAREA'].includes(document.activeElement?.tagName)&&!document.activeElement?.isContentEditable){const search=document.getElementById('searchInput');if(search){e.preventDefault();search.focus()}}});
  const cards=document.getElementById('notesContainer');
  function openCard(card){if(card?.dataset.id)window.location.assign(`{{ url('/content') }}/${encodeURIComponent(card.dataset.id)}/edit`)}
  cards?.addEventListener('click',e=>{if(e.target.closest('button,form,a'))return;openCard(e.target.closest('.note-card'))});
  cards?.addEventListener('keydown',e=>{if((e.key==='Enter'||e.key===' ')&&e.target.classList.contains('note-card')){e.preventDefault();openCard(e.target)}});
  const search=document.getElementById('searchInput'),date=document.getElementById('dateFilter'),sort=document.getElementById('sortSelect'),reset=document.getElementById('resetFilterBtn');
  let timer,controller;
  async function filterNotes(){if(!cards)return;controller?.abort();controller=new AbortController();const q=new URLSearchParams({search:search?.value.trim()||'',date:date?.value||'',sort:sort?.value||'desc',view:new URLSearchParams(location.search).get('view')||''});try{cards.setAttribute('aria-busy','true');const response=await fetch(`{{ route('content.index') }}?${q}`,{headers:{'X-Requested-With':'XMLHttpRequest'},signal:controller.signal});if(!response.ok)throw Error('Filter failed');const html=await response.text();const doc=new DOMParser().parseFromString(html,'text/html');const next=doc.getElementById('notesContainer');if(next)cards.innerHTML=next.innerHTML;history.replaceState(null,'',`${location.pathname}?${q}`)}catch(e){if(e.name!=='AbortError')console.error('Gagal memuat catatan:',e)}finally{cards.removeAttribute('aria-busy')}}
  search?.addEventListener('input',()=>{clearTimeout(timer);timer=setTimeout(filterNotes,280)});date?.addEventListener('change',filterNotes);sort?.addEventListener('change',filterNotes);reset?.addEventListener('click',()=>{if(search)search.value='';if(date)date.value='';if(sort)sort.value='desc';filterNotes()});
  @if(session('success') || session('status') || session('error'))
    const toast=document.createElement('div');toast.setAttribute('role','status');toast.textContent=@json(session('success') ?? session('status') ?? session('error'));Object.assign(toast.style,{position:'fixed',right:'20px',bottom:matchMedia('(max-width:760px)').matches?'calc(96px + env(safe-area-inset-bottom))':'20px',zIndex:'100',background:'#25243a',color:'#fff',padding:'15px 22px',borderRadius:'12px',boxShadow:'0 12px 30px #0002',fontSize:'13px'});document.body.appendChild(toast);setTimeout(()=>toast.remove(),3600);
  @endif
})();
</script>
