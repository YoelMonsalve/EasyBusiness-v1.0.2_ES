<ul>
  <li>
    <a href="admin.php">
      <i class="glyphicon glyphicon-home"></i>
      <span>Panel de control</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-user"></i>
      <span>Accesos</span>
    </a>

    <!-- Editado por Yoel (2020.05.27)
         No aparec'ian los submenus 
         Se cambio la clase "nav submenu" a "nav menu" 
         .............................................. -->
    <ul class="nav submenu">
    <!--<ul class="nav menu">-->
      <li><a href="groups.php">Grupos</a> </li>
      <li><a href="users.php">Usuarios</a> </li>
   </ul>
  </li>
  <li>
    <a href="categorie.php" >
      <i class="glyphicon glyphicon-indent-left"></i>

      <!-- Por Yoel.-
           Acentos en est'andar HTML: &aacute; &eacute; ... etc 
           .................................................. -->
      <span>Categor&iacute;as</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-large"></i>
      <span>Productos</span>
    </a>
    <ul class="nav submenu">
    <!--<ul class="nav menu">-->
      <li><a href="products.php">Administrar</a></li>
      <li><a href="add_product.php">Agregar</a></li>
   </ul>
  </li>
  <li>
    <a href="media.php" >
      <i class="glyphicon glyphicon-picture"></i>
      <span>Media</span>
    </a>
  </li>

  <!--
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-list"></i>
       <span>Entradas (TO-DO)</span>
    </a>
    <ul class="nav menu">
    -->
    <!--<ul class="nav submenu">-->
    <!--
      <li><a href="#">Administrar entradas (TO-DO)</a></li>
      <li><a href="#">Agregar entradas (TO-DO)</a> </li>
    </ul>
  </li>
  -->
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-plus"></i>
      <span>Ventas</span>
    </a>
    <!--<ul class="nav menu">-->
    <ul class="nav submenu">
      <li><a href="sales.php">Administrar</a> </li>
      <li><a href="add_sale.php">Agregar</a> </li>
    </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-stats"></i>
      <span>Reportes de Ventas</span>
    </a>
    <!--<ul class="nav menu">-->
    <ul class="nav submenu">
      <li><a href="daily_sales.php">Diario</a></li>
      <li><a href="weekly_sales.php">Semanal</a></li>
      <li><a href="monthly_sales.php">Mensual</a></li>
      <li><a href="sales_report.php">Rango de fecha</a></li>
    </ul>
  </li>
</ul>
