import os
import csv

with open('./autod.csv', "r", encoding="utf-8") as f:
    lines = f.readlines()

with open('./autod.sql', "w", encoding="utf-8") as f:
    f.write('USE PHPA;\n')
    for line in lines[1:]:
        fields = line.strip('\n').strip('&').split(';')
        url = fields[0],
        brand = fields[1],
        engine = fields[2],
        mileage = fields[3],
        fuel = fields[4],
        model = fields[5],
        model_short = fields[6],
        transmission = fields[7],
        year = fields[8],
        bodytype = fields[9],
        drive = fields[10],
        price = fields[11]
    
        f.write(f"""INSERT INTO autod(url, brand, engine, mileage, fuel, model, model_short, 
             transmission, year, bodytype, drive, price)
             VALUES ("{url[0]}", "{brand[0]}", "{engine[0]}", "{mileage[0]}", "{fuel[0]}", "{model[0]}", 
             "{model_short[0]}", "{transmission[0]}", "{year[0]}", "{bodytype[0]}", "{drive[0]}", "{price}");\n""")
    