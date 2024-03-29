<nav class="navbar navbar-expand-lg bg-dark navbar-expand-md shadow border-bottom border-top border-primary border-2 sticky-top">
    <div class="container-fluid">
        <a class="text-decoration-none" href="<?php BASE_PROJET?>/"><h1 class="navbar-brand text-info fs-3 fw-bold ms-1 me-5 mt-1"><i class="bi bi-film me-2"></i>Cinéma</h1></a>

        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul id="navigation" class="navbar-nav mt-0">
                <li class="nav-item">
                    <a class="link-offset-2 link-underline link-underline-opacity-0 text-info fw-semibold border-2 me-4 fs-5" href="<?php BASE_PROJET?>/liste-des-films.php">Liste des films</a>
                </li>
                <?php if (!empty($_SESSION)) : ?>
                    <li class="nav-item">
                        <a class="link-offset-2 link-underline link-underline-opacity-0 text-info fw-semibold border-2 fs-5" role="button" href="<?php BASE_PROJET?>/ajouter-film.php">Ajouter un film</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-end flex-grow-1 pe-3">
                <?php if (empty($_SESSION)) : ?>
                    <li class="nav-item">
                        <a class="btn btn-info fw-bold border-2 me-3" role="button" href="<?php BASE_PROJET?>/connexion.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-info fw-bold border-2" role="button" href="<?php BASE_PROJET?>/creation-de-compte.php">Inscription</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="btn btn-info fw-bold border-2" role="button" href="<?php BASE_PROJET?>/deconnexion.php">Déconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php if (isset($_SESSION['pseudo'])) : ?>
    <p class="fw-bold pt-5 me-5 fs-5 text-end">Heureux de vous revoir <span class="text-primary"><?= $pseudo ?></span> !</p>
<?php endif; ?>
