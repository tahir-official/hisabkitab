<!-- sidebar-->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
   <ul class="nav">
      <li class="nav-item nav-category" style="text-align: center;">Main Menu</li>
      <li class="nav-item div-mobile">
         <a class="nav-link" href="<?=MAIN_URL?>/profile.php">
         <i class="menu-icon typcn typcn-document-text"></i>
         <span class="menu-title">My Profile</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="<?=MAIN_URL?>/dashboard.php">
         <i class="menu-icon typcn typcn-document-text"></i>
         <span class="menu-title">Dashboard</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="<?=MAIN_URL?>/broker_management.php">
         <i class="menu-icon typcn typcn-document-text"></i>
         <span class="menu-title">Broker Management</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="<?=MAIN_URL?>/dealer_management.php">
         <i class="menu-icon typcn typcn-document-text"></i>
         <span class="menu-title">Dealer Management</span>
         </a>
      </li>

      <li class="nav-item">
         <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
         <i class="menu-icon typcn typcn-coffee"></i>
         <span class="menu-title">Bills Management</span>
         <i class="menu-arrow"></i>
         </a>
         <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
               <li class="nav-item">
                  <a class="nav-link" href="<?=MAIN_URL?>/all_bills.php"> All Bills</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="<?=MAIN_URL?>/add_bill.php"> Add Bill</a>
               </li>
              
            </ul>
         </div>
      </li>
      
      <!-- <li class="nav-item">
         <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
         <i class="menu-icon typcn typcn-coffee"></i>
         <span class="menu-title">Basic UI Elements</span>
         <i class="menu-arrow"></i>
         </a>
         <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
               <li class="nav-item">
                  <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
               </li>
            </ul>
         </div>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="pages/forms/basic_elements.html">
         <i class="menu-icon typcn typcn-shopping-bag"></i>
         <span class="menu-title">Form elements</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="pages/charts/chartjs.html">
         <i class="menu-icon typcn typcn-th-large-outline"></i>
         <span class="menu-title">Charts</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="pages/tables/basic-table.html">
         <i class="menu-icon typcn typcn-bell"></i>
         <span class="menu-title">Tables</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="pages/icons/font-awesome.html">
         <i class="menu-icon typcn typcn-user-outline"></i>
         <span class="menu-title">Icons</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
         <i class="menu-icon typcn typcn-document-add"></i>
         <span class="menu-title">User Pages</span>
         <i class="menu-arrow"></i>
         </a>
         <div class="collapse" id="auth">
            <ul class="nav flex-column sub-menu">
               <li class="nav-item">
                  <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="pages/samples/login.html"> Login </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="pages/samples/register.html"> Register </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="pages/samples/error-404.html"> 404 </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="pages/samples/error-500.html"> 500 </a>
               </li>
            </ul>
         </div>
      </li> -->
      <li class="nav-item div-mobile">
         <a class="nav-link" href="<?=MAIN_URL?>/logout.php">
         <i class="menu-icon typcn typcn-user-outline"></i>
         <span class="menu-title">Logout</span>
         </a>
      </li>
   </ul>
</nav>

