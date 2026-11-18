#!/usr/bin/env bash
# Pruebas de humo de la página principal (index.php).
# Uso: bash tests/test-index.sh
set -u

PUERTO=8089
URL="http://127.0.0.1:${PUERTO}/index.php"
FALLOS=0

verificar() {
  # $1 = descripción, $2 = código de salida de la comprobación
  if [ "$2" -eq 0 ]; then
    echo "✔ $1"
  else
    echo "✘ $1"
    FALLOS=$((FALLOS + 1))
  fi
}

# 1. Validación de sintaxis
php -l index.php > /dev/null
verificar "index.php no tiene errores de sintaxis" $?

# 2. Levanta el servidor embebido de PHP
php -S "127.0.0.1:${PUERTO}" > /dev/null 2>&1 &
PID_SERVIDOR=$!
trap 'kill $PID_SERVIDOR 2>/dev/null' EXIT

# Espera a que el servidor responda (máximo ~10 s)
for _ in $(seq 1 20); do
  curl -s -o /dev/null "$URL" && break
  sleep 0.5
done

# 3. Consulta la página
CUERPO=$(curl -s -D /tmp/cabeceras.txt "$URL")
CODIGO=$(head -n 1 /tmp/cabeceras.txt | awk '{print $2}')

[ "$CODIGO" = "200" ]
verificar "La página responde con HTTP 200 (obtenido: ${CODIGO:-ninguno})" $?

grep -qi "content-type: text/html" /tmp/cabeceras.txt
verificar "El Content-Type es text/html" $?

echo "$CUERPO" | grep -q "Hola estudiantes del ITM"
verificar "Muestra el saludo de bienvenida" $?

echo "$CUERPO" | grep -q "Despliegue continuo en GitHub"
verificar "Muestra el título principal" $?

echo "$CUERPO" | grep -q "cdn.tailwindcss.com"
verificar "Incluye Tailwind CSS" $?

# 4. Seguridad: no debe haber errores de PHP ni etiquetas sin procesar
! echo "$CUERPO" | grep -Eqi "Parse error|Fatal error|Warning:|Notice:|<\?php"
verificar "No hay errores de PHP ni código PHP sin ejecutar" $?

# 5. Seguridad: no debe filtrar valores de secretos
! echo "$CUERPO" | grep -Eq "ftp://|password=|passwd="
verificar "No expone credenciales" $?

echo "----"
if [ "$FALLOS" -gt 0 ]; then
  echo "Pruebas fallidas: ${FALLOS}"
  exit 1
fi
echo "Todas las pruebas pasaron"
