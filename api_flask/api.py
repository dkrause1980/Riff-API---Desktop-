from flask import Flask,jsonify, request
from db import DataBase
from flask_cors import CORS, cross_origin


app = Flask(__name__)

CORS(app)
#CORS(app,resources={r"/*":{ "origins":"*"}})
#app.config['CORS_HEADERS'] = 'Content-Type'


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
    
    empleado = db.change_pass(clave["contrasenia"],emp)
    return clave



@app.route('/insert_evento', methods=['POST'])
def post_evento():
    db = DataBase()
    data = request.json
    #print (jsonify(data))
    evento = db.insert_evento(data["comentario"],data["fecha_creacion"],data["id_tipo_falla"],data["latitud"],data["longitud"],data["legajo_tecnico"],data["calle"],data["numero"],data["piso"],data["depto"])
    
    return jsonify(data)

""" @app.route('/insert_tipo_falla', methods=['POST'])
def post_fallas():
    db = DataBase()
    data = request.json
    evento = db.insert_tipo_falla(data["cod_tipo_falla"],data["desc_falla"])
    
    return jsonify(data) """

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
    if estado["id_estado"]=="3":
        evento = db.update_evento_orden(e,estado["id_estado"])
    else:
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

@app.route('/ordenes')
def return_ordenes():
    db = DataBase()
    ordenes = db.get_ordenes()
    response = jsonify(ordenes)
    """ response.headers.set('Access-Control-Allow-Origin', '*')
    response.headers.set('Access-Control-Allow-Methods', 'GET, POST') """
    return response

@app.route('/ordenes/<string:o>')
def get_orden(o):
    db = DataBase()
    orden = db.select_order(o)
    return jsonify(orden)




@app.route('/ordenes/<string:o>',methods=['PUT'])
def put_orden(o):
    db = DataBase()
    data = request.json
    orden = db.update_order(o,data['cr1'],data['cr2'],data['cr3'],data['cr4'])
    return jsonify(orden)

@app.route('/tecnicos/<string:leg>',methods=['POST'])
def post_tecnico(leg):
    db = DataBase()
    data = request.json
    orden = db.create_user(leg,data['dni'],data['nombre'],data['apellido'],data['fecha_nac'],data['fecha_ing'],data['tel_pers'],data['email'],data['nivel'],data['activo'],data['tel_lab'],data['calle'],data['altura'],data['piso'],data['depto'])
    return jsonify(orden)

@app.route('/users')
def get_users_api():
    db = DataBase()
    users = db.get_users()
    return jsonify(users)

@app.route('/users/<string:leg>')
def get_user_api(leg):
    db = DataBase()
    user = db.get_user(leg)
    return jsonify(user)

@app.route('/tecnicos/<string:leg>',methods=['PUT'])
def put_tecnico(leg):
    db = DataBase()
    data = request.json
    if 'dni' in data:
        orden = db.update_user(leg,data['dni'],data['nombre'],data['apellido'],data['fecha_nac'],data['fecha_ing'],data['tel_pers'],data['email'],data['nivel'],data['activo'],data['tel_lab'],data['calle'],data['altura'],data['piso'],data['depto'])
    else:
        orden = db.deactivate_user(leg)
    return jsonify(data)

@app.route('/codigos_eventos')
def get_cod_eventos():
    db = DataBase()
    codigos = db.select_codigos_eventos()
    return jsonify(codigos)

@app.route('/codigos_eventos/<string:cod>',methods=['POST'])
def post_cod_event(cod):
    db = DataBase()
    data = request.json
    res = db.create_cod_event(cod,data['descripcion'],data['activo'])
    return jsonify(data)

@app.route('/codigos_eventos/<string:cod>')
def get_cod_api(cod):
    db = DataBase()
    res = db.get_cod_event(cod)
    return jsonify(res)

@app.route('/codigos_eventos/<string:cod>',methods=['PUT'])
def put_codigo(cod):
    db = DataBase()
    data = request.json
    if 'descripcion' in data:
        res = db.update_cod_event(cod,data['descripcion'],data['activo'])
    else:
        res = db.deactivate_cod_event(cod)
    return jsonify(data)

@app.route('/tareas_activas')
def get_tareas_activas():
    db = DataBase()
    codigos = db.get_tareas_activas()
    return jsonify(codigos)

@app.route('/tareas')
def get_tareas_api():
    db = DataBase()
    codigos = db.get_tareas()
    return jsonify(codigos)

@app.route('/tareas/<string:cod>',methods=['POST'])
def post_cod_rep(cod):
    db = DataBase()
    data = request.json
    res = db.create_cod_rep(cod,data['descripcion'],data['activo'])
    return jsonify(data)

@app.route('/tareas/<string:cod>')
def get_cod_api_rep(cod):
    db = DataBase()
    res = db.get_cod_rep(cod)
    return jsonify(res)

@app.route('/tareas/<string:cod>',methods=['PUT'])
def put_codigo_rep(cod):
    db = DataBase()
    data = request.json
    if 'descripcion' in data:
        res = db.update_cod_rep(cod,data['descripcion'],data['activo'])
    else:
        res = db.deactivate_cod_rep(cod)
    return jsonify(data)

@app.route('/olvida_clave/<string:leg>',methods=['PUT'])
def olvida_clave(leg):
    db = DataBase()
    clave = db.olvidaClave(leg)
    return jsonify(clave)


if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True)











#evento = db.insert_evento(data["comentario"],data["fecha_creacion"],data["id_tipo_falla"],data["latitud"],data["longitud"],
#        data["legajo_tecnico"],data["calle"],data["numero"],data["piso"],data["depto"],data["cod_postal"])
    


