// Установка сервис-воркера
self.addEventListener('install', function() {
    console.log('Service Worker installed');
  });
  
  // Активация сервис-воркера
  self.addEventListener('activate', function() {
    console.log('Service Worker activated');
  });
  