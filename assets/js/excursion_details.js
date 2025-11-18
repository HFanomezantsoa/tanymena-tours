(function(){
  'use strict';
  const qsa = (sel, ctx=document) => Array.from(ctx.querySelectorAll(sel));
  const hideAll = () => qsa('.excursion-detail').forEach(el => el.classList.remove('active'));
  const mapping = {
    'promenade-royale': 'promenade_royale',
    'sites-sacres': 'site_sacre',
    'artisans-ankaratra': 'ankaratra',
    'grand-marche': 'mercredi',
    'mpihira-gasy': 'danseur',
    'aromatherapie': 'aromatherapie',
    'promenade-equestre': 'equestre',
    'anjozorobe': 'phyto',
    'kivanja': 'kivanja'
  };
  function showDetail(id){
    hideAll();
    const section=document.getElementById(id);
    if(!section)return;
    section.classList.add('active');
    section.scrollIntoView({behavior:'smooth',block:'start'});
  }
  function handleHash(){
    const hash=location.hash.replace('#','');
    if(!hash)return;
    const target=mapping[hash]||hash;
    showDetail(target);
  }
  qsa('.btn-back-top').forEach(btn=>btn.addEventListener('click',()=>hideAll()));
  document.addEventListener('keydown',e=>{if(e.key==='Escape')hideAll();});
  window.addEventListener('load',handleHash);
  window.addEventListener('hashchange',handleHash);
})();