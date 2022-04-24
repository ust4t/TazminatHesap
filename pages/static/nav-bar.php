<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?=$siteUrl?>">DYKT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNavDropdown">
                <ul class="navbar-nav" style="margin-left:auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=$siteUrl?>">
                                <i class="fas fa-home"></i>
                            Anasayfa
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="tazminatTurleri" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-gavel" aria-hidden="true"></i>  Tazminatlar
                        </a>
                            <ul class="dropdown-menu" aria-labelledby="tazminatTurleri">
                                <li>
                                    <a class="dropdown-item" href="<?php echo $siteUrl;?>tazminat/destekten-yolsun-kalma">
                                        trh 2010 progressive run
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo $siteUrl ?>tazminat/pmf-1931">
                                        pmf 1931
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo $siteUrl ?>tazminat/is-gormez">
                                        iş göremezlik
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo $siteUrl ?>tazminat/is-gormez-1-8">
                                        iş göremezlik 1.8
                                    </a>
                                </li>
                            </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $user['namesurname'] ?>
                        </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="<?=$siteUrl."logout"?>">Çıkış Yap</a></li>
                            </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>