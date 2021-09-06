<!-- sidebar-->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
   <ul class="nav">
      <li class="nav-item nav-category" style="text-align: center;"><?=$adminData['name']?></li>
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
      <li class="nav-item div-mobile">
         <a class="nav-link" href="<?=MAIN_URL?>/logout.php">
         <i class="menu-icon typcn typcn-user-outline"></i>
         <span class="menu-title">Logout</span>
         </a>
      </li>
   </ul>
</nav>



