<div class="sidebar-menu toggle-others fixed">

    <div class="sidebar-menu-inner">

        <header class="logo-env">

            <!-- logo -->
            <div class="logo">
                <a href="#" class="logo-expanded"
                   style="color: #ffffff; font-size: 25px; font-weight: bolder">
                   TestAPP
                </a>
                <a href="#" class="logo-collapsed"
                   style="color: #ffffff; font-size: 25px; font-weight: bolder">
                    TA
                </a>
            </div>


            <div class="settings-icon">
                <a href="#" data-toggle="settings-pane" data-animate="true">
                    <i class="linecons-cog"></i>
                </a>
            </div>

        </header>
        <ul class="main-menu">
            <li class="<?php if ($page_name == 'products') echo 'active'; ?>">
                <a href="?page=products">
                    <i class="fa-database"></i>
                    <span>Articles</span>
                </a>
            </li>
            <li class="<?php if ($page_name == 'transactions') echo 'active'; ?>">
                <a href="?page=transactions">
                    <i class="fa-list"></i>
                    <span>Transactions</span>
                </a>
            </li>
            <li class="<?php if ($page_name == 'stock') echo 'active'; ?>">
                <a href="?page=stock">
                    <i class="fa-building"></i>
                    <span>Suivi de stock</span>
                </a>
            </li>

        </ul>

    </div>

</div>