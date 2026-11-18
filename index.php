<?php
    // Mensaje de bienvenida que se muestra en el encabezado
    $saludo = "Hola estudiantes del ITM 2026";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Despliegue continuo con GitHub Actions</title>
  <!-- Tailwind CSS vía CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

  <!-- Encabezado -->
  <header class="bg-gradient-to-br from-slate-900 to-indigo-900 text-white">
    <div class="max-w-5xl mx-auto px-6 py-16 text-center">
      <span class="inline-block bg-white/10 text-sm px-3 py-1 rounded-full mb-4">CI/CD · GitHub Actions · FTP</span>
      <p class="text-indigo-200 mb-2"><?php echo htmlspecialchars($saludo); ?></p>
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Despliegue continuo en GitHub</h1>
      <p class="text-lg text-slate-300 max-w-2xl mx-auto">
        Cada vez que subes cambios al repositorio, GitHub puede publicarlos
        automáticamente en tu servidor, sin copiar archivos a mano.
      </p>
    </div>
  </header>

  <main class="max-w-5xl mx-auto px-6 py-12 space-y-16">

    <!-- Qué es -->
    <section>
      <h2 class="text-2xl font-bold mb-4">¿Qué es el despliegue continuo?</h2>
      <p class="text-slate-600 leading-relaxed">
        El <strong>despliegue continuo (CD)</strong> es la práctica de publicar en producción,
        de forma automática, cada cambio que llega a la rama principal. En GitHub se logra con
        <strong>GitHub Actions</strong>: un archivo YAML describe qué debe pasar cuando ocurre un evento
        (por ejemplo, un <code class="bg-slate-200 px-1 rounded">push</code>).
      </p>
    </section>

    <!-- Flujo paso a paso -->
    <section>
      <h2 class="text-2xl font-bold mb-8">El flujo paso a paso</h2>

      <ol class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <li class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
          <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold mb-3">1</div>
          <h3 class="font-semibold mb-1">Programas y haces commit</h3>
          <p class="text-sm text-slate-600">Modificas el código en tu equipo y guardas los cambios con un <em>commit</em>.</p>
        </li>
        <li class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
          <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold mb-3">2</div>
          <h3 class="font-semibold mb-1">Haces push a main</h3>
          <p class="text-sm text-slate-600">Envías el commit al repositorio remoto en GitHub, en la rama <code class="bg-slate-200 px-1 rounded">main</code>.</p>
        </li>
        <li class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
          <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold mb-3">3</div>
          <h3 class="font-semibold mb-1">Se dispara el workflow</h3>
          <p class="text-sm text-slate-600">GitHub detecta el evento y lee el archivo <code class="bg-slate-200 px-1 rounded">.github/workflows/deploy-ftp.yml</code>.</p>
        </li>
        <li class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
          <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold mb-3">4</div>
          <h3 class="font-semibold mb-1">Se prepara un runner</h3>
          <p class="text-sm text-slate-600">GitHub levanta una máquina virtual temporal (<code class="bg-slate-200 px-1 rounded">ubuntu-latest</code>) y descarga tu código con <code class="bg-slate-200 px-1 rounded">checkout</code>.</p>
        </li>
        <li class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
          <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold mb-3">5</div>
          <h3 class="font-semibold mb-1">Se sube por FTP</h3>
          <p class="text-sm text-slate-600">Con los <em>secrets</em> (host, usuario y contraseña) se conecta al servidor y sube solo los archivos que cambiaron a <code class="bg-slate-200 px-1 rounded">/htdocs/</code>.</p>
        </li>
        <li class="bg-white rounded-xl shadow-sm border border-emerald-300 p-6">
          <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold mb-3">6</div>
          <h3 class="font-semibold mb-1">Sitio actualizado</h3>
          <p class="text-sm text-slate-600">Tu página ya está publicada con los últimos cambios. Puedes ver el resultado en la pestaña <strong>Actions</strong>.</p>
        </li>
      </ol>
    </section>

    <!-- Diagrama simple -->
    <section>
      <h2 class="text-2xl font-bold mb-6">Vista general</h2>
      <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-center">
        <div class="bg-white border border-slate-200 rounded-xl px-6 py-4 shadow-sm w-full md:w-auto">💻 Tu equipo</div>
        <div class="text-indigo-500 text-2xl rotate-90 md:rotate-0">➜</div>
        <div class="bg-white border border-slate-200 rounded-xl px-6 py-4 shadow-sm w-full md:w-auto">🐙 Repositorio GitHub</div>
        <div class="text-indigo-500 text-2xl rotate-90 md:rotate-0">➜</div>
        <div class="bg-indigo-600 text-white rounded-xl px-6 py-4 shadow-sm w-full md:w-auto">⚙️ GitHub Actions</div>
        <div class="text-indigo-500 text-2xl rotate-90 md:rotate-0">➜</div>
        <div class="bg-emerald-600 text-white rounded-xl px-6 py-4 shadow-sm w-full md:w-auto">🌐 Servidor FTP</div>
      </div>
    </section>

    <!-- Archivo YAML -->
    <section>
      <h2 class="text-2xl font-bold mb-4">El archivo del flujo</h2>
      <p class="text-slate-600 mb-4">Este es el corazón del despliegue, guardado en <code class="bg-slate-200 px-1 rounded">.github/workflows/deploy-ftp.yml</code>:</p>
      <pre class="bg-slate-900 text-slate-100 text-sm rounded-xl p-6 overflow-x-auto"><code>name: Despliegue FTP

on:
  push:
    branches: [main]
  workflow_dispatch:

jobs:
  desplegar:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4

      - uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_HOST }}
          username: ${{ secrets.FTP_USER }}
          password: ${{ secrets.FTP_PASSWORD }}
          server-dir: /htdocs/</code></pre>
    </section>

    <!-- Secrets -->
    <section>
      <h2 class="text-2xl font-bold mb-4">Secretos necesarios</h2>
      <p class="text-slate-600 mb-4">
        Las credenciales nunca se escriben en el código. Se guardan en
        <em>Settings → Secrets and variables → Actions</em>.
      </p>
      <div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
        <table class="w-full text-left text-sm">
          <thead class="bg-slate-100 text-slate-600">
            <tr><th class="px-4 py-3">Secreto</th><th class="px-4 py-3">Contenido</th></tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            <tr><td class="px-4 py-3 font-mono">FTP_HOST</td><td class="px-4 py-3">Hostname del servidor FTP</td></tr>
            <tr><td class="px-4 py-3 font-mono">FTP_USER</td><td class="px-4 py-3">Usuario del FTP</td></tr>
            <tr><td class="px-4 py-3 font-mono">FTP_PASSWORD</td><td class="px-4 py-3">Contraseña del FTP</td></tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Ventajas -->
    <section>
      <h2 class="text-2xl font-bold mb-6">Ventajas</h2>
      <div class="grid gap-4 md:grid-cols-3">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
          <h3 class="font-semibold mb-1">⚡ Rápido</h3>
          <p class="text-sm text-slate-600">Publicas en segundos con un simple <code>git push</code>.</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
          <h3 class="font-semibold mb-1">🔁 Repetible</h3>
          <p class="text-sm text-slate-600">El proceso es siempre el mismo, sin errores de copiado manual.</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
          <h3 class="font-semibold mb-1">🔒 Seguro</h3>
          <p class="text-sm text-slate-600">Las credenciales quedan cifradas en los secretos de GitHub.</p>
        </div>
      </div>
    </section>
  </main>

  <footer class="border-t border-slate-200 py-6 text-center text-sm text-slate-500">
    ITM <?php echo date('Y'); ?> · Despliegue continuo con GitHub Actions
  </footer>

</body>
</html>
