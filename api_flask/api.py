from flask import Flask,jsonify, request
from db import DataBase

app = Flask(__name__)



@app.route('/prueba')
def probando():
    return 'Funca!'

@app.route('/login/<string:emp>')
def get_empleado(emp):
    db = DataBase()
    empleado = db.select_employ(emp)
    return jsonify(empleado)

@app.route('/cambiarc/<string:emp>',methods=['PUT'])
def cambiar_pass(emp):
    db = DataBase()
    clave=request.json
    #print(clave[0])
    empleado = db.change_pass(clave[0]["contrasenia"],emp)
    return "{} registros afectados".format(empleado)

@app.route('/codigos_eventos')
def get_cod_eventos():
    db = DataBase()
    codigos = db.select_codigos_eventos()
    return jsonify(codigos)


if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)
    


