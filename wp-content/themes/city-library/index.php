<?php get_header(); ?>

<!-- Main Content Area -->
<main class="flex-1 bg-background-light dark:bg-background-dark py-16">
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
<!-- Headline -->
<div class="mb-12 flex flex-col items-center text-center md:flex-row md:justify-between md:text-left">
<div>
<h2 class="text-3xl font-bold tracking-tight text-navy-deep dark:text-white sm:text-4xl"><?php _e( 'Explore the Library', 'city-library' ); ?></h2>
<p class="mt-2 text-gray-600 dark:text-gray-400"><?php _e( 'Curated collections and resources for every interest.', 'city-library' ); ?></p>
</div>
<a class="mt-4 flex items-center gap-1 text-sm font-bold text-primary hover:text-blue-700 md:mt-0" href="#">
    <?php _e( 'View Full Catalog', 'city-library' ); ?> <span class="material-symbols-outlined text-base">arrow_forward</span>
</a>
</div>
<!-- Features Grid -->
<div class="grid gap-8 md:grid-cols-3">
<!-- Card 1: New Arrivals -->
<div class="group relative flex flex-col overflow-hidden rounded-2xl bg-white dark:bg-gray-900 shadow-sm transition-all hover:shadow-lg dark:border dark:border-gray-800">
<div class="aspect-video w-full overflow-hidden bg-gray-200 dark:bg-gray-800">
<div class="h-full w-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" data-alt="Stack of new colorful hardcover books on a wooden table" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBwE9bPzweYc2KP91G7HkkwZb5Iw6_oSoHPPtwBIrVcsld63rx4ETiuFrwPyCJ2NsiRR8Up252MIT4QO8Jm1ScT1BbAykbKP0STsF9IBT2I7GDATlG1f2FCe2dEGO0ayrI4UvoOQyz--oZ6tSsc4rEtPMPC7aJMUfCupfNsRpa1D-0wtQaevw75nQpqtb--RvToPejFBn437UTX5ComaKL8yqSmlHY6uUbnWSJCb0jnwdNJKq9KawS2Eheu03BTSGA_OZrQh9VLriFQ');"></div>
</div>
<div class="flex flex-1 flex-col p-6">
<div class="mb-3 flex items-center gap-2">
<span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/30 text-primary">
<span class="material-symbols-outlined text-lg">new_releases</span>
</span>
<span class="text-xs font-bold uppercase tracking-wider text-primary"><?php _e( 'Just In', 'city-library' ); ?></span>
</div>
<h3 class="mb-2 text-xl font-bold text-navy-deep dark:text-white"><?php _e( 'New Arrivals', 'city-library' ); ?></h3>
<p class="mb-6 flex-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
    <?php _e( 'Discover the latest bestsellers, award winners, and fresh additions to our shelves this week.', 'city-library' ); ?>
</p>
<button class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-transparent px-4 py-2.5 text-sm font-bold text-navy-deep dark:text-white transition-colors hover:bg-gray-50 dark:hover:bg-gray-800">
    <?php _e( 'Browse Collection', 'city-library' ); ?>
</button>
</div>
</div>
<!-- Card 2: Upcoming Events -->
<div class="group relative flex flex-col overflow-hidden rounded-2xl bg-white dark:bg-gray-900 shadow-sm transition-all hover:shadow-lg dark:border dark:border-gray-800">
<div class="aspect-video w-full overflow-hidden bg-gray-200 dark:bg-gray-800">
<div class="h-full w-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" data-alt="Group of people attending a workshop in a bright room" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCHRXKtrkXn5UwiJGNtnbf94Lqxm2IKA3asIX6-sc2jqNgnaB5OTYR2cbMkTR5YaFp1x-GSBFfpwzDasnuFN2Dbtw6d4In4Mm5ChRZlmYp_3dQgYlKpvqYebGXHs0Z_79mJsZh0_bOoH9PJNGF0BDLRRxlzaEEXXd8sk1FZNj9LYc6gzh4P6VtUWDJJceEpG_U6y2LFIhvpU54QYqloXpHB27coHdATsRJK1hbQwlsz4GgLAO4rEVGsZb11TJLiAIZX8nzcNoQOEvbt');"></div>
</div>
<div class="flex flex-1 flex-col p-6">
<div class="mb-3 flex items-center gap-2">
<span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/30 text-primary">
<span class="material-symbols-outlined text-lg">calendar_month</span>
</span>
<span class="text-xs font-bold uppercase tracking-wider text-primary"><?php _e( 'Events', 'city-library' ); ?></span>
</div>
<h3 class="mb-2 text-xl font-bold text-navy-deep dark:text-white"><?php _e( 'Upcoming Events', 'city-library' ); ?></h3>
<p class="mb-6 flex-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
    <?php _e( 'Join us for community workshops, author readings, and educational programs for all ages.', 'city-library' ); ?>
</p>
<button class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-transparent px-4 py-2.5 text-sm font-bold text-navy-deep dark:text-white transition-colors hover:bg-gray-50 dark:hover:bg-gray-800">
    <?php _e( 'View Calendar', 'city-library' ); ?>
</button>
</div>
</div>
<!-- Card 3: Digital Resources -->
<div class="group relative flex flex-col overflow-hidden rounded-2xl bg-white dark:bg-gray-900 shadow-sm transition-all hover:shadow-lg dark:border dark:border-gray-800">
<div class="aspect-video w-full overflow-hidden bg-gray-200 dark:bg-gray-800">
<div class="h-full w-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" data-alt="Digital tablet displaying colorful data and graphs" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAxlus9KvgSgmTGA7qdxOwQbZ74_XIlToA1Z3s_JeHH3CGY8mjuuycpXh-F4eueCLU_E3nTL1CcQ9HUiWcCFwzTVPNDdPvS6bxqNkadQeZc6e1rToJ745D9BdA0-AJ-jeKg3Moa4G2oqs6_uG503dSDda-AGGTwvdtOkK1oDRuYt92Mm8CXWi3FI3YmeMqejRamK4de-eroWpqQLvki6aiiCEm2d36a0WS66EZYCEn_uJpGKVoL1LyDQrrD1U2akx9giu2u0fn_GUjt');"></div>
</div>
<div class="flex flex-1 flex-col p-6">
<div class="mb-3 flex items-center gap-2">
<span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/30 text-primary">
<span class="material-symbols-outlined text-lg">cloud_download</span>
</span>
<span class="text-xs font-bold uppercase tracking-wider text-primary"><?php _e( 'Online', 'city-library' ); ?></span>
</div>
<h3 class="mb-2 text-xl font-bold text-navy-deep dark:text-white"><?php _e( 'Digital Resources', 'city-library' ); ?></h3>
<p class="mb-6 flex-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
    <?php _e( 'Access e-books, research databases, audiobooks, and streaming media from anywhere.', 'city-library' ); ?>
</p>
<button class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-transparent px-4 py-2.5 text-sm font-bold text-navy-deep dark:text-white transition-colors hover:bg-gray-50 dark:hover:bg-gray-800">
    <?php _e( 'Access Portal', 'city-library' ); ?>
</button>
</div>
</div>
</div>
<!-- Promotional Banner -->
<div class="mt-20 overflow-hidden rounded-2xl bg-navy-deep text-white shadow-xl dark:bg-gray-800">
<div class="flex flex-col md:flex-row">
<div class="flex-1 p-8 sm:p-12">
<div class="mb-4 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium backdrop-blur-sm">
    <span class="material-symbols-outlined text-sm text-gold-accent">star</span>
    <?php _e( 'Featured Service', 'city-library' ); ?>
</div>
<h2 class="mb-4 text-3xl font-bold tracking-tight text-white sm:text-4xl"><?php _e( 'Study Spaces Available', 'city-library' ); ?></h2>
<p class="mb-8 max-w-md text-gray-300">
    <?php _e( 'Need a quiet place to work or collaborate? Reserve a private study room or conference area for your group today.', 'city-library' ); ?>
</p>
<div class="flex flex-wrap gap-4">
    <button class="flex items-center justify-center rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white shadow-lg transition-colors hover:bg-blue-700">
        <?php _e( 'Reserve a Room', 'city-library' ); ?>
    </button>
    <button class="flex items-center justify-center rounded-lg bg-white/10 px-6 py-3 text-sm font-bold text-white backdrop-blur-sm transition-colors hover:bg-white/20">
        <?php _e( 'Learn More', 'city-library' ); ?>
    </button>
</div>
</div>
<div class="relative min-h-[300px] w-full flex-1 bg-gray-700 md:min-h-auto">
<div class="absolute inset-0 bg-cover bg-center" data-alt="Modern bright open study area with desks and chairs" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuD896yxbivehKvC9Vkq-tz8DADJFQfbY0P4Oj0aoJb7FylMcC1wYlr4WmpXMG011LE14W_bVtCvdccZRyLhrS9otVLkBWlbsFOOKaeXoA7cg16WGqtvTq407JoPIt2wYAftqaG05Ds3T0Au3KGaHT-gCHbMrJqB6fOJ0BsQRT3CYJQZ_mFHMLtjtsbeJkH9GzV1ygpzBwlEwqn1Atp5aM976wH5JCRKNPpgIAZe2TRqYNyJlRNOh_o12GyCHTfJ2BFeUnzAmzXUf1Ip');"></div>
<div class="absolute inset-0 bg-gradient-to-t from-navy-deep/80 to-transparent md:bg-gradient-to-l"></div>
</div>
</div>
</div>
</div>
</main>

<?php get_footer(); ?>
