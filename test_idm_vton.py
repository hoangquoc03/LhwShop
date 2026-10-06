from gradio_client import Client, handle_file
import shutil
import os

print("Connecting IDM-VTON...")

client = Client("yisol/IDM-VTON")

print("Connected!")

result = client.predict(
    {
        "background": handle_file("test-person.jpg"),
        "layers": [],
        "composite": None,
    },
    handle_file("test-garment.jpg"),
    "Denim jacket",
    True,
    False,
    30,
    42,
    api_name="/tryon",
)

output_image = result[0]
masked_image = result[1]

print("\nOUTPUT:")
print(output_image)

print("\nMASK:")
print(masked_image)

shutil.copyfile(output_image, "tryon-result.png")
shutil.copyfile(masked_image, "tryon-mask.png")

print("\nSaved:")
print("tryon-result.png")
print("tryon-mask.png")