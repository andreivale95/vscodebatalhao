@if (session('success'))
<div id="alert-box" class="alert alert-success alert-dismissible" style="z-index:1000; position: fixed; right: 0px; margin-right:2em; margin-top:1em; display:none">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
  {{ session('success') }}
</div>
@endif
@if (session('warning'))
<div id="alert-box" class="alert alert-warning alert-dismissible" style="z-index:1000; position: fixed; right: 0px; margin-right:2em; margin-top:1em; display:none">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-warning"></i> Alerta!</h4>
  {{ session('warning') }}
</div>
@endif
@if (session('error'))
<div id="alert-box" class="alert alert-danger alert-dismissible pull-right" style="z-index:1000; position: fixed; right: 0px; margin-right:2em; margin-top:1em; display:none">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
  {{ session('error') }}
</div>
@endif
@if (session('info'))
<div id="alert-box" class="alert alert-info alert-dismissible" style="z-index:1000; position: fixed; right: 0px; margin-right:2em; margin-top:1em; display:none">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-info"></i> Aviso!</h4>
  {{ session('info') }}
</div>
@endif