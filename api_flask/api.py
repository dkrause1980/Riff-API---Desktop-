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

@app.route('/log/<string:emp>')
def get_log(emp):
    db = DataBase()
    clave = request.json
    res = db.login(emp,clave["contrasenia"])
    return jsonify(res)

@app.route('/login/<string:emp>',methods=['PATCH'])
def cambiar_pass(emp):
    db = DataBase()
    clave=request.json
    print (clave)
    #print(clave[0])
    empleado = db.change_pass(clave["contrasenia"],emp)
    return clave

@app.route('/codigos_eventos')
def get_cod_eventos():
    db = DataBase()
    codigos = db.select_codigos_eventos()
    return jsonify(codigos)

@app.route('/insert_evento', methods=['POST'])
def post_evento():
    db = DataBase()
    data = request.json
    
    evento = db.insert_evento(data["comentario"],data["fecha_creacion"],data["id_tipo_falla"],data["latitud"],data["longitud"],data["legajo_tecnico"],data["calle"],data["numero"],data["piso"],data["depto"])
    
    return jsonify(data)

@app.route('/insert_tipo_falla', methods=['POST'])
def post_fallas():
    db = DataBase()
    data = request.json
    evento = db.insert_tipo_falla(data["cod_tipo_falla"],data["desc_falla"])
    
    return jsonify(data)

@app.route('/eventos')
def return_eventos():
    db = DataBase()
    eventos = db.get_eventos()
    response = jsonify(eventos)
    """ response.headers.set('Access-Control-Allow-Origin', '*')
    response.headers.set('Access-Control-Allow-Methods', 'GET, POST') """
    return response

@app.route('/tecnicos')
def return_tecnicos():
    db = DataBase()
    tecnicos = db.get_tecnicos_nivel2()
    return jsonify(tecnicos)

@app.route('/eventos/<string:e>')
def get_evento(e):
    db = DataBase()
    evento = db.select_event(e)
    return jsonify(evento)

@app.route('/eventos/<string:e>',methods=['PUT'])
def update_event(e):
    db = DataBase()
    estado = request.json
    evento = db.update_evento(e,estado["id_estado"])
    return jsonify(evento)

@app.route('/insert_orden', methods=['POST'])
def post_orden():
    db = DataBase()
    data = request.json
    evento = db.create_orden(data["id_evento"],data["tecnico"])
    
    return jsonify(data)

@app.route('/eventos/tecnico/<string:t>')
def get_evento_tecnico(t):
    db = DataBase()
    #data = request.json
    evento = db.select_event_legajo(t)
    return jsonify(evento)





if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)

#evento = db.insert_evento(data["comentario"],data["fecha_creacion"],data["id_tipo_falla"],data["latitud"],data["longitud"],
#        data["legajo_tecnico"],data["calle"],data["numero"],data["piso"],data["depto"],data["cod_postal"])
    


