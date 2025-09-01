// arquivo global de frontend (public/js/app.js)
console.log('MacroTracker app.js loaded');

$(function(){
  // Global AJAX setup
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  // Exemplos de handlers globais
  $(document).on('ajaxError', function(e, xhr){
    if(xhr.status === 401) {
      alert('Não autenticado. Por favor faça login.');
      return;
    }
    // mensagens do servidor
    const msg = xhr.responseJSON?.message || 'Ocorreu um erro.';
    console.error('AJAX Error', xhr);
    // opcional: exibir toast
  });
});
