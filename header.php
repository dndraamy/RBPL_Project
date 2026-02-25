<header class="px-6 pt-10 pb-4 text-white">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold tracking-tight"><?php echo $title; ?></h1>
            <p class="text-xs font-light mt-1 opacity-90"><?php echo $subtitle; ?></p>
        </div>

        <div class="flex items-center gap-3 mt-3">
            <a href="login.php" class="hover:opacity-80 transition-opacity active:scale-90 transform duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" x2="9" y1="12" y2="12"></line>
                </svg>
            </a>

            <button class="hover:opacity-80 transition-opacity active:scale-90 transform duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <circle cx="12" cy="10" r="3"></circle>
                    <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
                </svg>
            </button>
        </div>
    </div>
</header>