
<!-- Main Footer -->
<footer class="main-footer" style="">
  <strong>Copyright &copy;<a target="_blank" href="https://diogosubtil.com.br">Diogo Subtil</a></strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Versão</b> 2.0
  </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="/assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="/assets/plugins/raphael/raphael.min.js"></script>
<script src="/assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="/assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/plugins/jquery-knob/jquery.knob.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="/assets/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/assets/js/pages/dashboard2.js"></script>
<!-- Menu Scripts -->
<script src="/assets/js/pages/menu.js"></script>
<!-- SweetAlert -->
<script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Alert Toastr -->
<script src="/assets/plugins/toastr/toastr.min.js"></script>



<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<script>
    function excluir() {
        return confirm('Você realmente deseja excluir?');
    }
</script>
<script>
    $(function() {
        window.onload = function() {
            if (document.getElementById('success')) {
                toastr.success('Ação realizada com sucesso.', 'Sucesso!', {
                    progressBar: true,
                    timeOut: 5000,
                });
            }
            if (document.getElementById('error')) {
                toastr.error('Ocorreu algum erro na sua ação.', 'Erro!', {
                    progressBar: true,
                    timeOut: 5000,
                });
            }
            if (document.getElementById('editado')) {
                toastr.success('Editado com sucesso.', 'Editado!', {
                    progressBar: true,
                    timeOut: 5000,
                });
            }
        }
    });
</script>
</body>
</html>
