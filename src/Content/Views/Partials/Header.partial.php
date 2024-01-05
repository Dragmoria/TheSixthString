<?php
function buildCategoryMenu($category, int $index): void
{
    echo '<a class="dropdown-item" style="padding-left: calc(var(--bs-dropdown-item-padding-x) + 1.5rem * ' . $index . ');" href="/Category/' . $category->id . '">' . $category->name . '</a>';

    ++$index;
    foreach ($category->children as $childCategory) {
        buildCategoryMenu($childCategory, $index);
    }
}
?>


<!-- Navbar Large screens -->
<nav class="navbar navbar-expand-lg nav-lg fixed-top flex-column py-0 d-none d-lg-block">
    <div class="container-fluid px-0 py-2">
        <!-- Logo -->
        <a class="navbar-brand pt-0 mx-5" href="/">
            <img src="/images/logo-small.svg" alt="Sixth" width="60px">
        </a>
        
        <!-- Search Bar -->
        <div class="dropdown">
            <div class="d-flex">
                <input type="text" id="product-search-big" class="form-control w-auto bg-sixth-beige rounded-4"
                    placeholder="Zoek een product" data-target-dropdown="suggested-results"
                    onkeyup="searchSuggested(this)" />
                <span class="input-group-text border-0 bg-transparent" onclick="executeSearch()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-search text-sixth-beige cursor-pointer" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
            </div>
            </span>
            <ul id="suggested-results" class="dropdown-menu"></ul>
        </div>

        <!-- Links & Buttons -->
        <ul class="navbar-nav ms-auto justify-content-center" style="font-weight: 500;">
            <?php echo component(\Http\Controllers\Components\CategoryMenuComponent::class); ?>
            <li class="nav-item">
                <a class="nav-link text-sixth-beige" href="/Service">Service</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-sixth-beige" href="/Overig">Overig</a>
            </li>
            <?php
            if (currentRole() !== null && currentRole()->hasRightsOf(Lib\Enums\Role::Analyst)) {
                echo '<li class="nav-item">';
                echo '<a class="nav-link text-sixth-beige" href="/ControlPanel">Control panel</a>';
                echo '</li>';
            }
            ?>
            <div class="dropdown custom-dropdown">
                <form id="logoutForm" method="POST" action="/LogOut">
                    <li class="nav-item mx-3">
                        <a class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center nav-button"
                            href="/Account">
                            <img src="/images/account-icon.png" alt="Account" width="17" height="17">
                        </a>
                        <div class="dropdown-menu start-0" style="margin-left: -85px;"
                            aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/Account">Account pagina</a>
                            <? if (isset($_SESSION['user'])) {
                                echo '
              <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById(\'logoutForm\').submit();">Uitloggen</a>';
                            } else {
                                echo '<a class="dropdown-item" href="/Login">Inloggen</a>';
                            }
                            ?>
                        </div>
                    </li>
                </form>
            </div>
            <li class="nav-item me-5">
                <a class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center nav-button"
                    href="/ShoppingCart">
                    <img src="/images/basket-icon.png" alt="Mand" width="17" height="17">
                </a>
            </li>
        </ul>
    </div>

    <!-- KPI Bar -->
    <div class="container-fluid kpi-bar align-items-center justify-content-center">
        <img src="/images/kpi-sending.png" alt="Sending" style="height: 70%;">
        <p class="m-0 ps-1 pe-4" style="font-size: 0.5rem;">Gratis verzending vanaf € 100,-</p>
        <img src="/images/kpi-time.png" alt="Sending" style="height: 70%;">
        <p class="m-0 ps-1 pe-4" style="font-size: 0.5rem;">Voor 23:00 besteld, morgen in huis!</p>
        <img src="/images/kpi-warranty.png" alt="Sending" style="height: 70%;">
        <p class="m-0 ps-1 pe-4" style="font-size: 0.5rem;">30 dagen “niet-goed-geld-terug” garantie</p>
        <img src="/images/kpi-service.png" alt="Sending" style="height: 70%;">
        <p class="m-0 ps-1 pe-4" style="font-size: 0.5rem;">3 jaar garantie van Sixth</p>
    </div>

</nav>

<!-- Navbar Mobile -->
<nav class="navbar navbar-expand-lg nav-sm navbar-dark bg-dark sticky-top flex-column py-0 d-lg-none"
     style="background-color:var(--sixth-brown) !important;">
    <div class="container-fluid px-0 pt-3">
        <!-- Logo and Search Bar on the left -->
        <a class="navbar-brand pt-0 mx-3" href="#">
            <img src="/images/logo-small.svg" alt="Your Logo">
        </a>
        <div class="d-flex ms-auto">
            <button class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                style="background-color: var(--sixth-yellow);border-color: var(--sixth-yellow); width: 40px; height: 40px;">
                <img src="/images/account-icon.png" alt="Account" width="17" height="17">
            </button>
            <a class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center"
                style="background-color: var(--sixth-yellow);border-color: var(--sixth-yellow); width: 40px; height: 40px;"
                href="/ShoppingCart">
                <img src="/images/basket-icon.png" alt="Mand" width="17" height="17">
            </a>
        </div>
        <!-- Hamburger Menu Button -->
        <button class="navbar-toggler mx-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Links and Buttons on the right -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto justify-content-center" style="font-weight: 500;">
                <?php echo component(\Http\Controllers\Components\CategoryMenuComponent::class); ?>
                <li class="nav-item">`
                    <a class="nav-link" href="/Service" style="color: var(--sixth-beige)">Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Overig" style="color: var(--sixth-beige)">Overig</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="container-fluid px-3 my-3 justify-content-center align-items-center">
        <div class="input-group">
            <div class="dropdown">
                <div class="d-flex">
                    <input type="text" id="product-search-small" class="form-control w-auto bg-sixth-beige rounded-4"
                        placeholder="Zoek een product" data-target-dropdown="suggested-results-sm"
                        onkeyup="searchSuggested(this)" />
                    <span class="input-group-text border-0 bg-transparent" onclick="executeSearch()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-search text-sixth-beige cursor-pointer" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                </div>
                </span>
                <ul id="suggested-results-sm" class="dropdown-menu"></ul>
            </div>
        </div>
    </div>

    <!-- KPI Bar -->
    <div class="container-fluid" style="height: 15px; background-color: var(--sixth-yellow);"></div>

</nav>

<script>
    var searchTimer = null;

    function searchSuggested(element) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            if ($(element).val().length > 3) {
                $.post('/Product/GetSuggestedProducts', { search: $(element).val() }, function (response) {
                    var dropdownId = '#' + $(element).data('target-dropdown');
                    $(dropdownId + ' li').remove();

                    if (response.products.length <= 0) {
                        $(dropdownId).append('<li class="p-2">Geen producten gevonden</li>');
                    }

                    $.each(response.products, function (i, el) {
                        var suggestedProduct = '<li class="p-2"><a class="text-decoration-none text-sixth-black" href="/Product/' + el.id + '">' + el.name + '</a></li>';
                        $(dropdownId).append(suggestedProduct);
                    });

                    $(dropdownId).dropdown('show');
                });
            }
        }, 750);
    }

    $(document).on('click', function () {
        $('.dropdown-menu').removeClass('show');
    });

    function executeSearch() {
        window.location.href = '/Product?search=' + $('#product-search').val();
    }
</script>