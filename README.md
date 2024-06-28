# instalacion/configuracion del proyecto

# forma de subir los archivos 

1) git add . (para subir todos los archivos que tienen cambios)
2) git commit -m "tarea nueva" (para subir al area del commit y prepararlos para subirlos al area remoto)
3) git push origin main (sube el archivo al github)

# pasos para descargar los cambios

1) git pull origin main 

<<<<<<< HEAD
# pasos para clonar el repositorio por primera vez
=======
# pasos para clonar el repositorio por prigmera vez
>>>>>>> master

1) git clone https://github.com/ciro713/miTransporte.git

# RAMAS

cuando estemos trabajando con una nueva funcionalidad o cambio, vamos a crear una nueva rama

1) crear rama:

git checkout -b nombredelarama

2) hagan commit con frecuencia

git add .

git commit -m "describan bien los cambios"

3) sincronizar con la rama principal(sincronizamos los cambios del resto del equipo)

git checkout main
git pull origin main
git checkout nombre-de-la-rama
git merge main

(pueden surgir conflictos en algunas lineas de codigo, las resuelven para poder seguir)

4) subir la rama al repositorio remoto

git push origin nombre-de-la-rama(main)

# Manejo de Conflictos

despues de resolver los conflictos hacen un commit:

git add archivo-en-conflicto
git commit -m "Resolución de conflictos en archivo-en-conflicto"

