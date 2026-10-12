const connection = document.getElementById('pwaConnection');
const installButton = document.getElementById('pwaInstall');
const setConnection = () => { if (connection) {connection.textContent = navigator.onLine ? 'Online' : 'Offline'; connection.classList.toggle('is-offline', !navigator.onLine);} };
window.addEventListener('online', setConnection);window.addEventListener('offline', setConnection);setConnection();
if ('serviceWorker' in navigator && (location.protocol === 'https:' || location.hostname === 'localhost' || location.hostname === '127.0.0.1')) {
  window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js').catch(error => console.warn('PWA service worker:', error)));
}
let deferredInstall;
window.addEventListener('beforeinstallprompt', event => {event.preventDefault();deferredInstall=event;if(installButton)installButton.hidden=false;});
installButton?.addEventListener('click', async () => {if(!deferredInstall)return;deferredInstall.prompt();await deferredInstall.userChoice;deferredInstall=undefined;installButton.hidden=true;});
window.addEventListener('appinstalled', () => {deferredInstall=undefined;if(installButton)installButton.hidden=true;});
