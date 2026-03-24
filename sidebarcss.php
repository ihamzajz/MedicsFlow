 <style>
     .wrapper {
         display: flex;
         width: 100%;
         align-items: stretch;
     }
     #sidebar {
         min-width: 250px;
         max-width: 250px;
         background: #292E34 !important;
         background-color: #292E34 !important;
         color: #fff;
         transition: all 0.3s;
         margin-left: -250px;
     }
     #sidebar.active {
         margin-left: 0;
     }
     #sidebar .sidebar-header {
         padding: 20px;
         background: #292E34 !important;
     }
     #sidebar ul.components {
         padding: 10px 0;
     }
     #sidebar ul p {
         color: #fff;
         padding: 8px !important;
     }
     #sidebar ul li a {
         padding: 8px !important;
         padding-bottom: 4px !important;
         font-size: 10.6px !important;
         display: block;
         color: white !important;
         position: relative;
     }
     #sidebar ul li a:hover {
         text-decoration: none;
     }
     #sidebar ul li.active>a,
     a[aria-expanded="true"] {
         color: cyan !important;
         background: #292E34 !important;
     }
     #sidebar a {
         position: relative;
         padding-right: 40px;
     }
     .toggle-icon {
         font-size: 12px;
         color: #fff;
         position: absolute;
         right: 20px;
         top: 50%;
         transform: translateY(-50%);
         transition: transform 0.3s;
     }
     .collapse.show+a .toggle-icon {
         transform: translateY(-50%) rotate(45deg);
     }
     .collapse:not(.show)+a .toggle-icon {
         transform: translateY(-50%) rotate(0deg);
     }
     ul ul a {
         font-size: 11px !important;
         padding-left: 15px !important;
         background: #263144 !important;
         color: #fff !important;
     }
     ul.CTAs {
         font-size: 11px !important;
     }
     ul.CTAs a {
         text-align: center;
         font-size: 11px !important;
         display: block;
         margin-bottom: 5px;
     }
     a.download {
         background: #fff;
         color: #292E34 !important;
     }
     a.article,
     a.article:hover {
         background: #292E34 !important;
         color: #fff !important;
     }
     #content {
         width: 100%;
         padding: 0px;
         min-height: 100vh;
         transition: all 0.3s;
     }
     @media (max-width: 768px) {
         #sidebar {
             margin-left: -250px;
         }
         #sidebar.active {
             margin-left: 0;
         }
         #sidebarCollapse span {
             display: none;
         }
     }
     .main-1 {
         letter-spacing: 0.5px;
         font-size: 12px !important;
         background: #DA22FF;
         background: -webkit-linear-gradient(to right, #9733EE, #DA22FF);
         background: linear-gradient(to right, #9733EE, #DA22FF);
     }
     .main-2 {
         background: #56CCF2;
         background: -webkit-linear-gradient(to right, #2F80ED, #56CCF2);
         background: linear-gradient(to right, #2F80ED, #56CCF2);
     }
     .main-3 {
         background: #F00000;
         background: -webkit-linear-gradient(to right, #DC281E, #F00000);
         background: linear-gradient(to right, #DC281E, #F00000);
     }
     .main-4 {
         letter-spacing: 0.5px;
         background: #003973;
         /* fallback for old browsers */
         background: -webkit-linear-gradient(to right, #E5E5BE, #003973);
         /* Chrome 10-25, Safari 5.1-6 */
         background: linear-gradient(to right, #E5E5BE, #003973);
         /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
         font-size: 12px !important
     }
     .main-xt {
         background: #67B26F;
         /* fallback for old browsers */
         background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);
         /* Chrome 10-25, Safari 5.1-6 */
         background: linear-gradient(to right, #4ca2cd, #67B26F);
         /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
     }
 </style>