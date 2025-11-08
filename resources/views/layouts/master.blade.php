@include("layouts.header")

<div class="wrapper">


 @include("layouts.topbar")

 @include("layouts.sidebar")
  <div class="content-wrapper">
    <div class="content-header">
       
       @yield("page")

</div>
</div>

 

 <footer class="main-footer">
    <strong>Copyright &copy; 2025 <a href="https://adminlte.io">Rony</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>
     
</div>
@include("layouts.right_slidebar")
@include("layouts.footer")



