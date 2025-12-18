<?php
$settings = [
    'Log Errors'          => ini_get('log_errors'),
    'Memory Limit'        => ini_get('memory_limit'),
    'Max Execution Time'  => ini_get('max_execution_time'),
    'Max Input Time'      => ini_get('max_input_time'),
    'Post Max Size'       => ini_get('post_max_size'),
    'Upload Max Filesize' => ini_get('upload_max_filesize'),
    'Default Charset'     => ini_get('default_charset'),
];

$extensions = get_loaded_extensions();
sort($extensions);

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>PHP Container Details</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#0ea5e9",
            "background-light": "#f3f4f6",
            "background-dark": "#0f172a",
            "card-light": "#ffffff",
            "card-dark": "#1e293b",
            "border-light": "#e2e8f0",
            "border-dark": "#334155",
          },
          fontFamily: {
            display: ["Inter", "sans-serif"],
            body: ["Inter", "sans-serif"],
          },
          borderRadius: { DEFAULT: "0.5rem" },
        },
      },
    };
  </script>
  <style>
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .dark ::-webkit-scrollbar-thumb { background: #475569; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    .dark ::-webkit-scrollbar-thumb:hover { background: #64748b; }
  </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-body antialiased min-h-screen transition-colors duration-300 relative overflow-x-hidden">
  <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
    <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary/20 dark:bg-primary/10 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-cyan-500/20 dark:bg-cyan-900/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
  </div>

  <main class="max-w-4xl mx-auto px-4 py-10 lg:py-16 space-y-6">
    <div class="bg-card-light dark:bg-card-dark rounded-xl shadow-lg border border-border-light dark:border-border-dark p-6 lg:p-8 backdrop-blur-sm bg-opacity-90 dark:bg-opacity-90">
      <div class="flex flex-col lg:flex-row justify-between gap-8">
        <div class="flex-1 space-y-4">
          <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight mb-2">PHP Container Info</h1>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
              Lightweight, hardened PHP-FPM + Nginx image with overridable runtime limits. Optimized for performance and security.
            </p>
          </div>
          <div class="flex flex-wrap gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
              PHP <?php echo htmlspecialchars(PHP_VERSION, ENT_QUOTES, 'UTF-8'); ?>
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700 font-mono">
              <?php echo htmlspecialchars(date(DATE_ATOM), ENT_QUOTES, 'UTF-8'); ?>
            </span>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4 min-w-[300px]">
          <div class="bg-gray-50 dark:bg-slate-800/50 rounded-lg p-4 border border-border-light dark:border-border-dark relative overflow-hidden group">
            <div class="absolute inset-0 bg-primary/5 dark:bg-primary/10 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 relative z-10">Extensions</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white relative z-10"><?php echo count($extensions); ?></p>
          </div>
          <div class="bg-gray-50 dark:bg-slate-800/50 rounded-lg p-4 border border-border-light dark:border-border-dark relative overflow-hidden group">
            <div class="absolute inset-0 bg-primary/5 dark:bg-primary/10 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 relative z-10">Memory Limit</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white relative z-10"><?php echo htmlspecialchars($settings['Memory Limit'], ENT_QUOTES, 'UTF-8'); ?></p>
          </div>
          <div class="bg-gray-50 dark:bg-slate-800/50 rounded-lg p-4 border border-border-light dark:border-border-dark col-span-2 relative overflow-hidden group">
            <div class="absolute inset-0 bg-primary/5 dark:bg-primary/10 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
            <div class="flex justify-between items-end relative z-10">
              <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Upload Max</h3>
                <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo htmlspecialchars($settings['Upload Max Filesize'], ENT_QUOTES, 'UTF-8'); ?></p>
              </div>
              <span class="material-icons text-gray-400 dark:text-gray-600">cloud_upload</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-card-light dark:bg-card-dark rounded-xl shadow-lg border border-border-light dark:border-border-dark overflow-hidden">
      <div class="px-6 py-4 border-b border-border-light dark:border-border-dark bg-gray-50 dark:bg-slate-800/30">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Key Limits</h2>
      </div>
      <div class="divide-y divide-border-light dark:divide-border-dark">
        <?php foreach ($settings as $key => $value): ?>
          <div class="grid grid-cols-2 px-6 py-3 hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide flex items-center"><?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?></span>
            <span class="text-sm text-gray-900 dark:text-gray-200 text-right font-mono"><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="bg-card-light dark:bg-card-dark rounded-xl shadow-lg border border-border-light dark:border-border-dark overflow-hidden">
      <div class="px-6 py-4 border-b border-border-light dark:border-border-dark bg-gray-50 dark:bg-slate-800/30 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Loaded Extensions <span class="ml-1 text-sm text-gray-500 font-normal">(<?php echo count($extensions); ?>)</span></h2>
      </div>
      <div class="p-6">
        <div class="flex flex-wrap gap-2">
          <?php foreach ($extensions as $ext): ?>
            <span class="px-2.5 py-1 rounded text-xs font-semibold bg-gray-200 text-gray-700 dark:bg-slate-700 dark:text-gray-300 border border-transparent hover:border-primary/50 cursor-default transition-all">
              <?php echo htmlspecialchars($ext, ENT_QUOTES, 'UTF-8'); ?>
            </span>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="bg-card-light dark:bg-card-dark rounded-xl shadow-lg border border-border-light dark:border-border-dark p-6">
      <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">About This Repo</h2>
      <div class="prose dark:prose-invert max-w-none text-sm text-gray-600 dark:text-gray-400">
        <p class="mb-3">
          Alpine-based PHP-FPM + Nginx, multi-arch, non-root runtime, and tunable PHP settings via env/compose.
        </p>
        <ul class="list-disc pl-5 space-y-1">
          <li>Maintainer: <a class="text-primary hover:underline" href="https://github.com/nooblk-98" target="_blank" rel="noopener noreferrer">nooblk-98</a></li>
          <li>Images: 7.4, 8.1, 8.2, 8.3, 8.4 (8.4 tagged as latest)</li>
          <li>Health: nginx proxy to PHP-FPM socket, supervisord-managed</li>
          <li>Config: override PHP limits through environment variables</li>
        </ul>
      </div>
    </div>
  </main>
</body>
</html>
