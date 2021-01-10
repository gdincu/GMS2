
    <!-- Navigation -->
    <!-- Name & Logo -->
    <nav    class="navbar   p-0 " 
            style="background-color: #333A56;" 
            id="mainNav" 
        >

        <div class="container">
            <div class="row ">
                <div class="container input-group input-group-sm">
                    <a  class="navbar-brand js-scroll-trigger" 
                        href="<?php echo isLoggedIn() ? 'index.php?page=user' : 'index.php'?>" 
                        style="color: #E8E8E8">
						GMS
                    </a>
                </div>
            </div>

            <div class="form-row">
                <!--Profile form-->
                <form method="post" class="form-inline" action="index.php?page=user"> 
                    <div class="col-sm-2s" style="margin-right: 5px;">
                        <button type="submit" 
                                class="btn btn-sm btn-info btn-block" 
                                name = "profile" 
                                style="background-color: #52658F; border-color: #52658F; color: #E8E8E8; margin-left: 3%;">Profile</button>
                    </div>
                </form>

                <!--Login Form-->
                <form method="post" class="form-inline" > 
                    <div    class="col-sm-2s" 
                            style="margin-right: 50px;"
                        >
                        <button type="submit" 
                                class="btn btn-sm btn-info btn-block" 
                                name = "access" 
                                style="background-color: #52658F; border-color: #52658F; color: #E8E8E8; margin-left: 3%;">Log Out</button>
                    </div>
                </form>
            </div>    
        </div>
    </nav>

    <br><br><br><br><br>
