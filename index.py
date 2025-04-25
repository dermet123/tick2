import qrcode

# URL del archivo que deseas que se descargue al escanear el QR
url = "http://localhost/Generador_Tickets/generatePDF.php?id=6"

# Crear el código QR
qr = qrcode.QRCode(
    version=1,
    error_correction=qrcode.constants.ERROR_CORRECT_H,
    box_size=10,
    border=4,
)
qr.add_data(url)
qr.make(fit=True)

# Crear la imagen del código QR
img = qr.make_image(fill_color="black", back_color="white")

# Guardar la imagen en un archivo
img.save("codigo_qr.png")
