import random
import math # Aunque no se usa directamente en la nueva lógica, se mantenía por si acaso en el cálculo de pesos original.

def elegir_multiplicador_y_apuesta_con_secundaria():
    """
    Elige un multiplicador (1-30) con probabilidad decreciente y una
    apuesta (1-20) inversamente relacionada.

    Adicionalmente, puede generar una segunda apuesta y multiplicador
    basado en las siguientes condiciones:
    - Si el primer multiplicador es > 4 O si la primera apuesta es > 10.

    La segunda apuesta será el doble de la primera y su multiplicador será 1.5.

    Retorna:
        tuple: (multiplicador_1, apuesta_1, multiplicador_2, apuesta_2)
               Donde multiplicador_2 y apuesta_2 pueden ser None si no se cumplen
               las condiciones para la segunda apuesta.
    """

    # --- Parte 1: Elegir el Multiplicador (1-30) ---
    multiplicadores_posibles = list(range(1, 31))
    pesos_multiplicador = [31 - m for m in multiplicadores_posibles]
    multiplicador_elegido = random.choices(multiplicadores_posibles,
                                          weights=pesos_multiplicador,
                                          k=1)[0]

    # --- Parte 2: Elegir la Apuesta (1-20) ---
    apuestas_posibles = list(range(1, 21))
    # Mapeo lineal inverso aproximado para el centro ideal
    centro_ideal_apuesta = 20.5 - (multiplicador_elegido - 1) * (19 / 29)
    pesos_apuesta = []
    for apuesta in apuestas_posibles:
        distancia = abs(apuesta - centro_ideal_apuesta)
        peso = 1.0 / (distancia**2 + 1.0)
        pesos_apuesta.append(peso)

    apuesta_elegida = random.choices(apuestas_posibles,
                                      weights=pesos_apuesta,
                                      k=1)[0]

    # --- Parte 3: Decidir y Calcular la Segunda Apuesta ---
    multiplicador_secundario = None
    apuesta_secundaria = None

    # Condiciones para agregar la segunda apuesta (OR lógico)
    if multiplicador_elegido > 4 or apuesta_elegida > 10:
        apuesta_secundaria = apuesta_elegida * 2
        multiplicador_secundario = 1.5

    return multiplicador_elegido, apuesta_elegida, multiplicador_secundario, apuesta_secundaria

# --- Ejecutar la función y mostrar resultados ---
if __name__ == "__main__":
    print("Ejecutando la selección con posible segunda apuesta...")
    print("-" * 60) # Separador

    # Ejecutarlo varias veces para ver la tendencia y la segunda apuesta
    for i in range(15): # Aumentamos a 15 intentos para ver más casos
        multiplicador, apuesta, multi_sec, apuesta_sec = elegir_multiplicador_y_apuesta_con_secundaria()

        # Construir el string del resultado
        resultado_str = f"Intento {i+1:2d}: Multiplicador = {multiplicador:2d}, Apuesta = {apuesta:2d}"

        # Añadir la información de la segunda apuesta si existe
        if apuesta_sec is not None: # Equivalente a verificar si multi_sec is not None
            resultado_str += f"  -> Segunda Apuesta: Sí (Mult={multi_sec:.1f}, Apuesta={apuesta_sec:3d})"
        else:
            resultado_str += "  -> Segunda Apuesta: No"

        print(resultado_str)

    print("-" * 60)
    print("\nObserva cuándo aparece la 'Segunda Apuesta':")
    print(" - Cuando el Multiplicador es 5 o mayor.")
    print(" - O cuando la Apuesta es 11 o mayor.")


#     esto quiero un select de su nombre para seleccionar en pdf,
# <a href="../generatePDF.php" class="mt-2 inline-block text-blue-600 hover:underline">Generar PDF</a>
# esto es el lis en generarpdf quiero cuando apreto me salga esas opciones
# <?php
# require_once '../config/database.php';

# $stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
# $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

# echo json_encode($users);

# function generarReporte(userId) {
#     window.open(generatePDF.php?id=${userId}, '_blank');
#   }