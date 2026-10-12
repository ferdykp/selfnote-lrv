// SelfNote writing engine: no third-party editor dependency, no document.execCommand.
(() => {
 const form=document.querySelector('#createNoteForm, #editNoteForm');if(!form)return;
 const editor=form.querySelector('#editor,#editEditor'),hidden=form.querySelector('#hiddenContent,#editHiddenContent');
 if(!editor||!hidden)return;
 const title=form.querySelector('[data-note-title]'), statusInput=form.querySelector('#createStatusInput,#editStatusInput'),status=form.querySelector('[data-autosave-status]');
 const tags=form.querySelector('[name=tags]'),image=form.querySelector('input[type=file][name=image]');
 const key='selfnote:autosave:'+location.pathname;
 const announce=message=>{if(status)status.textContent=message};
 const changed=()=>editor.dispatchEvent(new Event('input',{bubbles:true}));
 const selection=()=>{const s=window.getSelection();return s?.rangeCount&&editor.contains(s.anchorNode)&&editor.contains(s.focusNode)?s:null};
 const replaceRange=(node,range)=>{range.deleteContents();range.insertNode(node);range.setStartAfter(node);range.collapse(true);const s=window.getSelection();s.removeAllRanges();s.addRange(range);changed()};
 const closestBlock=node=>{let e=node?.nodeType===1?node:node?.parentElement;return e?.closest('p,div,h1,h2,h3,blockquote,li')||null};
 const wrapSelection=tag=>{const s=selection();if(!s||s.isCollapsed){announce('Pilih teks terlebih dahulu untuk memformatnya.');return}const r=s.getRangeAt(0),el=document.createElement(tag);try{r.surroundContents(el)}catch{el.append(r.extractContents());r.insertNode(el)}s.removeAllRanges();const after=document.createRange();after.selectNodeContents(el);s.addRange(after);changed()};
 const formatBlock=tag=>{const s=selection();if(!s){editor.focus();return}const block=closestBlock(s.anchorNode);if(!block||block===editor){const el=document.createElement(tag);el.textContent=s.toString()||'Tulis di sini';replaceRange(el,s.getRangeAt(0));return}if(block.tagName.toLowerCase()===tag)return;const replacement=document.createElement(tag);while(block.firstChild)replacement.appendChild(block.firstChild);block.replaceWith(replacement);const r=document.createRange();r.selectNodeContents(replacement);r.collapse(false);s.removeAllRanges();s.addRange(r);changed()};
 const format=cmd=>{editor.focus();const map={bold:'strong',italic:'em',underline:'u',strike:'s',code:'code'};
  if(map[cmd])return wrapSelection(map[cmd]);
  if(['h1','h2','h3','blockquote','paragraph'].includes(cmd))return formatBlock(cmd==='paragraph'?'p':cmd);
  const s=selection();if(!s)return;
  if(cmd.startsWith('align-')){const b=closestBlock(s.anchorNode);if(b&&b!==editor){b.style.textAlign=cmd.slice(6);changed()}return}
  if(cmd==='insertUnorderedList'||cmd==='insertOrderedList'){const list=document.createElement(cmd==='insertOrderedList'?'ol':'ul');const li=document.createElement('li');li.textContent=s.toString()||'Item baru';list.append(li);replaceRange(list,s.getRangeAt(0));return}
  if(cmd==='clear'&&!s.isCollapsed){replaceRange(document.createTextNode(s.toString()),s.getRangeAt(0))}
 };
 form.querySelectorAll('[data-cmd]').forEach(b=>{b.addEventListener('mousedown',e=>e.preventDefault());b.addEventListener('click',()=>format(b.dataset.cmd))});
 form.querySelector('[data-editor-link]')?.addEventListener('mousedown',e=>e.preventDefault());
 form.querySelector('[data-editor-link]')?.addEventListener('click',()=>{const s=selection();if(!s||s.isCollapsed)return announce('Blok teks dahulu sebelum membuat tautan.');const url=prompt('Masukkan URL (https://…)');if(!url)return;try{const href=new URL(url);if(!['http:','https:'].includes(href.protocol))throw Error();const a=document.createElement('a');a.href=href.href;a.target='_blank';a.rel='noopener noreferrer';a.textContent=s.toString();replaceRange(a,s.getRangeAt(0))}catch{announce('URL harus dimulai dengan https:// atau http://')}});
 form.querySelector('[data-cover-trigger]')?.addEventListener('click',()=>image?.click());image?.addEventListener('change',()=>announce(image.files[0]?'Cover dipilih: '+image.files[0].name:'Cover belum dipilih'));
 // Markdown inline delimiters apply only in the current text node when a closing token is typed.
 function markdownInline(){const s=selection();if(!s||!s.isCollapsed)return;const node=s.anchorNode;if(node?.nodeType!==Node.TEXT_NODE)return;const pos=s.anchorOffset,before=node.textContent.slice(0,pos);
 const patterns=[[/\*\*([^*\n]+)\*\*$/,'strong'],[/~~([^~\n]+)~~$/,'s'],[/\*([^*\n]+)\*$/,'em'],[/_([^_\n]+)_$/,'em'],[/`([^`\n]+)`$/,'code']];
 for(const [re,tag] of patterns){const m=before.match(re);if(!m)continue;const range=document.createRange();range.setStart(node,pos-m[0].length);range.setEnd(node,pos);const el=document.createElement(tag);el.textContent=m[1];replaceRange(el,range);return}}
 // Markdown prefixes trigger when user types a space after a new block marker.
 function markdownBlock(){const s=selection();if(!s||!s.isCollapsed)return;const node=s.anchorNode;if(node?.nodeType!==Node.TEXT_NODE)return;const pos=s.anchorOffset,before=node.textContent.slice(0,pos),match=before.match(/^(#{1,3}|[-*]|1\.|>) $/);if(!match)return;
 const marker=match[1];let block=closestBlock(node);if(!block)return;
 if(block===editor){const paragraph=document.createElement('p');node.parentNode.insertBefore(paragraph,node);paragraph.appendChild(node);block=paragraph;}
 const range=document.createRange();range.setStart(node,0);range.setEnd(node,pos);range.deleteContents();
 if(marker==='-'||marker==='*'||marker==='1.'){const list=document.createElement(marker==='1.'?'ol':'ul');const li=document.createElement('li');while(block.firstChild)li.append(block.firstChild);list.append(li);block.replaceWith(list);const r=document.createRange();r.selectNodeContents(li);r.collapse(true);s.removeAllRanges();s.addRange(r)}else{const tag=marker==='>'?'blockquote':'h'+marker.length;const el=document.createElement(tag);while(block.firstChild)el.append(block.firstChild);block.replaceWith(el);const r=document.createRange();r.selectNodeContents(el);r.collapse(true);s.removeAllRanges();s.addRange(r)}changed()}
 editor.addEventListener('input',e=>{if(e.inputType==='insertText'){if(e.data===' '){markdownBlock()}else if(['*','~','_','`'].includes(e.data)){markdownInline()}}});
 editor.addEventListener('keydown',e=>{const mod=e.ctrlKey||e.metaKey;if(mod){const command={b:'bold',i:'italic',u:'underline'}[e.key.toLowerCase()];if(command){e.preventDefault();format(command)}}});
 editor.addEventListener('paste',e=>{e.preventDefault();const text=e.clipboardData?.getData('text/plain')||'';const s=selection();if(s)replaceRange(document.createTextNode(text),s.getRangeAt(0))});
 // Retain offline quick capture and local draft recovery.
 const offlineId=new URLSearchParams(location.search).get('offline_draft');if(offlineId&&form.id==='createNoteForm'){try{const records=JSON.parse(localStorage.getItem('selfnote:offline-drafts:v1')||'[]');const d=records.find(x=>x.id===offlineId);if(d){title.value=d.title;editor.textContent=d.content;announce('Draft offline dimuat. Simpan untuk memasukkannya ke database.')}}catch{}}
 const snapshot=()=>({title:title?.value||'',content:editor.innerHTML,tags:tags?.value||'',at:Date.now()});
 const starting=snapshot();let debounce;const queue=()=>{announce('Perubahan belum disimpan');clearTimeout(debounce);debounce=setTimeout(()=>{try{localStorage.setItem(key,JSON.stringify(snapshot()));announce('Draft tersimpan di perangkat ini')}catch{announce('Penyimpanan lokal tidak tersedia; simpan secara manual')}},600)};
 [editor,title,tags].forEach(el=>el?.addEventListener('input',queue));
 try{const d=JSON.parse(localStorage.getItem(key)||'null');if(d?.at&&(d.title!==starting.title||d.content!==starting.content||d.tags!==starting.tags)){const restore=document.createElement('button');restore.type='button';restore.className='draft-recover';restore.textContent='Pulihkan draft lokal';status?.after(restore);restore.addEventListener('click',()=>{title.value=d.title||'';editor.innerHTML=d.content||'';if(tags)tags.value=d.tags||'';restore.remove();announce('Draft dipulihkan. Klik Simpan untuk menyimpan di server.')})}}catch{}
 const submit=state=>{if(statusInput)statusInput.value=state;if(!title?.value.trim()){title?.focus();return announce('Judul tidak boleh kosong')}if(!editor.textContent.trim()){editor.focus();return announce('Isi catatan belum ditulis')}hidden.value=editor.innerHTML.trim();if(!form.reportValidity())return;HTMLFormElement.prototype.submit.call(form)};
 form.querySelectorAll('[data-save-status]').forEach(btn=>btn.addEventListener('click',()=>submit(btn.dataset.saveStatus)));
 form.addEventListener('submit',e=>{e.preventDefault();submit(statusInput?.value||'draft')});
})();
