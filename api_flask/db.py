import pymysql
from datetime import datetime
import hashlib
import random



class DataBase:
    def __init__(self):
        self.connection = pymysql.connect(
            host = 'localhost',
            user = 'diego',
            password = 'root',
            db = 'Riff2'
        )

        self.cursor = self.connection.cursor()

    def login(self,legajo,contrasenia):
        sql = 'SELECT legajo, nombre, apellido, nivel FROM Empleados WHERE legajo = {} AND contrasenia = SHA1({})'.format(legajo,contrasenia)
        try:
            self.cursor.execute(sql)
            res = self.cursor.fetchone()
            content = {}
            if res!=None:
                content = {'legajo':res[0],'nombre':res[1],'apellido':res[2],'nivel':res[3]}
            return content
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def select_employ(self,legajo):
        sql = 'SELECT * FROM Empleados WHERE legajo = {}'.format(legajo)

        try:
            self.cursor.execute(sql)
            empleado = self.cursor.fetchone()
            if empleado!=None:
                
                content = {'legajo':empleado[0],'nombre':empleado[2],'contrasenia':empleado[9],'apellido':empleado[3],'nivel':empleado[10], 'activo':empleado[11]}
            else:
                content = {}
            return content
        except Exception as e:
            raise
        finally:
            self.connection.close()
    
        
    def change_pass(self,contrasenia,legajo):

        sql = 'UPDATE Empleados SET contrasenia="{}" WHERE legajo={}'.format(contrasenia,legajo)
        try:
            self.cursor.execute(sql)
            self.connection.commit()
            
            # payload = []
            # content = {}
            # for res in empleado:
            #     content = {'legajo':res[0],'nombre':res[2],'contrasenia':res[9]}
            #     payload.append(content)
            #     content = {}
            return None
            
        except Exception as e:
            raise
        finally:
            self.connection.close()
    

    def select_codigos_eventos(self):

        sql = 'SELECT id_tipo_falla,cod_tipo_falla, desc_falla, activo FROM TipoFallas'

        try:
            self.cursor.execute(sql)
            codigos = self.cursor.fetchall()
            if codigos!=None:
                payload = []
                content = {}
                for res in codigos:
                    content = {'id_tipo_falla':res[0],'codigo':res[1],'descripcion':res[2], 'activo':res[3]}
                    payload.append(content)
                    content = {}
            else:
                payload = []
            return payload
        except Exception as e:
            raise
        finally:
            self.connection.close()

    
    def insert_evento(self,comentario,fecha_creacion,id_tipo_falla,latitud,longitud,
        legajo_tecnico,calle,numero,piso,depto):

        sql = 'INSERT INTO Eventos(comentario,fecha_creacion,id_tipo_falla,latitud,longitud,legajo_tecnico,id_estado,calle,numero,piso,depto,cod_postal) values ("{}",NOW(),{},{},{},"{}",1,"{}","{}","{}","{}","2300")'.format(comentario,id_tipo_falla,latitud,longitud,legajo_tecnico,calle,numero,piso,depto)
       
        try:
            self.cursor.execute(sql)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            self.connection.close()

    """ def insert_tipo_falla(self,cod_falla,desc_falla):
        sql = 'INSERT INTO TipoFallas(cod_tipo_falla,desc_falla) values ("{}","{}")'.format(cod_falla,desc_falla)

        try:
            self.cursor.execute(sql)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            self.connection.close() """

    def get_eventos(self):
        sql = '''SELECT e.id_evento, e.fecha_creacion, e.legajo_tecnico, e.calle, e.numero, e.piso, e.depto, 
        t.desc_falla, est.desc_estado, e.latitud, e.longitud, e.comentario FROM Eventos AS e, TipoFallas as t, Estados as est
        WHERE e.id_tipo_falla = t.id_tipo_falla AND e.id_estado = est.id_estado'''

        try:
            self.cursor.execute(sql)
            eventos = self.cursor.fetchall()
            if eventos!=None:
                payload = []
                content = {}
                for evento in eventos:
                    content = {'id_evento':evento[0],'fecha_creacion':datetime.strftime(evento[1],"%d-%m-%y"),'legajo_tecnico':evento[2],'calle':evento[3],
                    'altura':evento[4],'piso':evento[5],'depto':evento[6],'desc_falla':evento[7],'desc_estado':evento[8],'latitud':evento[9],
                    'longitud':evento[10],'comentario':evento[11]}
                    payload.append(content)
                    content = {}
            else:
                payload = []
            return payload
        except Exception as e:
            raise
        finally:
            self.connection.close()


    def get_tecnicos_nivel2(self):
        sql = '''SELECT legajo, nombre, apellido, nivel FROM Empleados WHERE nivel = 2'''

        try:
            self.cursor.execute(sql)
            tecnicos = self.cursor.fetchall()
            if tecnicos!=None:
                payload = []
                content = {}
                for t in tecnicos:
                    content = {'legajo': t[0],'nombre': t[1],'apellido':t[2]}
                    payload.append(content)
                    content = {}
            else:
                payload = []
            return payload
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def select_event(self,id_evento):
        sql = '''SELECT e.id_evento, e.comentario, e.fecha_creacion, t.desc_falla, e.latitud, e.longitud,e.legajo_tecnico,
        est.desc_estado, e.calle, e.numero, e.piso, e.depto FROM Eventos AS e, TipoFallas as t, Estados as est
        WHERE e.id_tipo_falla = t.id_tipo_falla AND e.id_estado = est.id_estado AND e.id_evento = {}'''.format(id_evento)

        try:
            self.cursor.execute(sql)
            evento = self.cursor.fetchone()
            if evento!=None:
                content = {'id_evento':evento[0],'comentario':evento[1],'fecha_creacion':datetime.strftime(evento[2],"%d-%m-%y"),
                'desc_falla':evento[3],'latitud':evento[4],'longitud':evento[5],'legajo_tecnico':evento[6],'desc_estado':evento[7],
                'calle':evento[8],'altura':evento[9],'piso':evento[10],'depto':evento[11]}
            else:
                content = {}
            return content
        except Exception as e:
            raise
        finally:
            self.connection.close()
    
    def update_evento(self,id_evento,id_estado):

        sql = 'UPDATE Eventos SET id_estado={} WHERE id_evento={}'.format(id_estado,id_evento)
        try:
            self.cursor.execute(sql)
            self.connection.commit()
            
            return None
            
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def update_evento_orden(self,id_evento,id_estado):

        sql = 'UPDATE Eventos SET id_estado={} WHERE id_evento={}'.format(id_estado,id_evento)
        sql2 = 'UPDATE Ordenes AS o, Eventos as e SET o.fecha_resolucion=NOW() WHERE o.id_evento = {}'.format(id_evento) 
        try:
            self.cursor.execute(sql)
            self.cursor.execute(sql2)
            self.connection.commit()
            
            return None
            
        except Exception as e:
            raise
        finally:
            self.connection.close()
    
    def create_orden(self,id_evento,tecnico):

        sql = 'INSERT INTO Ordenes(legajo_tecnico,fecha_creacion,id_evento) values ("{}",NOW(),{})'.format(tecnico,id_evento)

        try:
            self.cursor.execute(sql)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def select_event_legajo(self,legajo):

        sql = '''SELECT e.id_evento, e.comentario, e.fecha_creacion, t.desc_falla, est.desc_estado, e.calle, e.numero, e.piso, e.depto FROM Eventos AS e, TipoFallas as t, Estados as est
        WHERE e.id_tipo_falla = t.id_tipo_falla AND e.id_estado = est.id_estado AND e.legajo_tecnico = {}'''.format(legajo)

        try:
            self.cursor.execute(sql)
            eventos = self.cursor.fetchall()
            content = {}
            payload = []
            if eventos!=None:
                for evento in eventos:
                    content = {'id_evento':evento[0],'comentario':evento[1],'fecha_creacion':datetime.strftime(evento[2],"%d-%m-%y"),
                    'desc_falla':evento[3],'desc_estado':evento[4],'calle':evento[5],'numero':evento[6],'piso':evento[7],'depto':evento[8]}
                    payload.append(content)
                    content = {}

            return payload
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def get_ordenes(self):
        sql = '''SELECT o.id_orden, o.fecha_creacion, o.legajo_tecnico, o.fecha_resolucion, o.id_evento, est.desc_estado, o.cod_resolucion1, o.cod_resolucion2,o.cod_resolucion3, o.cod_resolucion4 
        FROM Eventos as e, Ordenes AS o, Estados as est
        WHERE  e.id_estado = est.id_estado AND o.id_evento=e.id_evento'''

        try:
            self.cursor.execute(sql)
            eventos = self.cursor.fetchall()
            if eventos!=None:
                payload = []
                content = {}
                for evento in eventos:
                    if evento[3]==None:
                        fecha_res = "-"
                    else:
                        fecha_res = datetime.strftime(evento[3],"%d-%m-%y")
                    content = {'id_orden':evento[0],'fecha_creacion':datetime.strftime(evento[1],"%d-%m-%y"),'legajo_tecnico':evento[2], 'fecha_resolucion':fecha_res,
                    'id_evento':evento[4], 'estado':evento[5], 'cod_resolucion1':evento[6], 'cod_resolucion2':evento[7],'cod_resolucion3':evento[8],'cod_resolucion4':evento[9]}
                    payload.append(content)
                    content = {}
            else:
                payload = []
            return payload
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def select_order(self,id_orden):
        sql = '''SELECT o.id_orden, o.fecha_creacion, o.legajo_tecnico, o.fecha_resolucion, o.id_evento, est.desc_estado FROM Ordenes AS o, Estados as est, Eventos as e 
        WHERE e.id_estado = est.id_estado AND o.id_evento=e.id_evento AND o.id_orden = {}'''.format(id_orden)

        try:
            self.cursor.execute(sql)
            orden = self.cursor.fetchone()
            if orden!=None:
                if orden[3]==None:
                        fecha_res = "-"
                else:
                        fecha_res = datetime.strftime(orden[3],"%d-%m-%y")

                content = {'id_orden':orden[0],'fecha_creacion':datetime.strftime(orden[1],"%d-%m-%y"),'legajo_tecnico':orden[2],'fecha_resolucion':fecha_res,
                'id_evento':orden[4],'desc_estado':orden[5]}
            else:
                content = {}
            return content
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def get_tareas_activas(self):

        sql = '''SELECT * FROM CodigosResolucion WHERE activo=1'''

        try:
            self.cursor.execute(sql)
            tareas = self.cursor.fetchall()
            if tareas!=None:
                payload = []
                content = {}
                for tarea in tareas:
                    content = {'cod_resolucion':tarea[0],'desc_codigo':tarea[1],'activo':tarea[2]}
                    payload.append(content)
                    content = {}
            else:
                payload = []
            return payload
        except Exception as e:
            raise
        finally:
            self.connection.close()
    
    def get_tareas(self):

        sql = '''SELECT * FROM CodigosResolucion'''

        try:
            self.cursor.execute(sql)
            tareas = self.cursor.fetchall()
            if tareas!=None:
                payload = []
                content = {}
                for tarea in tareas:
                    content = {'cod_resolucion':tarea[0],'desc_codigo':tarea[1],'activo':tarea[2]}
                    payload.append(content)
                    content = {}
            else:
                payload = []
            return payload
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def update_order(self,id_orden,cod_resolucion1, cod_resolucion2, cod_resolucion3, cod_resolucion4):

        sql = '''UPDATE Ordenes 
        SET cod_resolucion1 = "{}",cod_resolucion2="{}", cod_resolucion3="{}", cod_resolucion4="{}"
        WHERE id_orden={}'''.format(cod_resolucion1, cod_resolucion2, cod_resolucion3, cod_resolucion4,id_orden)
        

        try:
            self.cursor.execute(sql)
            self.connection.commit()
            return None
        except Exception as e:
            raise
        finally:
            self.connection.close()


    
    def create_user(self, legajo, dni, nombre, apellido, fecha_nacimiento, fecha_ingreso, telefono_personal, email, nivel, activo, tel_laboral,calle,altura,piso,depto):

        sql='''INSERT INTO Domicilios (calle, numero, piso, depto, cod_postal, id_provincia) VALUES ("{}","{}","{}","{}","2300",3)'''.format(calle, altura, piso, depto)
        self.cursor.execute(sql)
        id_domicilio = self.cursor.lastrowid
        sql2='''INSERT INTO Empleados(legajo, dni, nombre, apellido, fecha_nacimiento, fecha_ingreso, telefono_personal, email,id_domicilio,contrasenia, nivel, activo, tel_laboral) 
        VALUES("{}","{}","{}","{}","{}","{}","{}","{}",{},"{}","{}",{},"{}")'''.format(legajo, dni, nombre, apellido, fecha_nacimiento, fecha_ingreso, telefono_personal, email,id_domicilio,dni,nivel,activo,tel_laboral)
        try:
            self.cursor.execute(sql2)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            
            self.connection.close()

    def get_users(self):

        sql = '''SELECT e.legajo, e.dni, e.nombre, e.apellido, e.fecha_nacimiento, e.fecha_ingreso, e.telefono_personal,e.tel_laboral, e.email, d.calle, d.numero, d.piso, d.depto, e.nivel, e.activo 
        FROM Empleados AS e, Domicilios as d WHERE e.id_domicilio = d.id_domicilio'''

        try:
            self.cursor.execute(sql)
            users = self.cursor.fetchall()
            if users!=None:
                payload = []
                content = {}
                for user in users:
                    content = {'legajo':user[0],'dni':user[1],'nombre':user[2],'apellido':user[3],'fecha_nac':user[4],'fecha_ing':user[5],'tel_pers':user[6],'tel_lab':user[7],
                    'email':user[8],'calle':user[9],'altura':user[10],'piso':user[11],'depto':user[12],'nivel':user[13],'activo':user[14]}
                    payload.append(content)
                    content = {}
            else:
                payload = []
            return payload
        except Exception as e:
            raise
        finally:
            self.connection.close()
    
    def get_user(self,legajo):

        sql = '''SELECT e.legajo, e.dni, e.nombre, e.apellido, e.fecha_nacimiento, e.fecha_ingreso, e.telefono_personal,e.tel_laboral, e.email, d.calle, d.numero, d.piso, d.depto, e.nivel, e.activo 
        FROM Empleados AS e, Domicilios as d WHERE e.id_domicilio = d.id_domicilio AND e.legajo = "{}"'''.format(legajo)

        try:
            self.cursor.execute(sql)
            user = self.cursor.fetchone()
            if user!=None:
                content = {}
                content = {'legajo':user[0],'dni':user[1],'nombre':user[2],'apellido':user[3],'fecha_nac':user[4],'fecha_ing':user[5],'tel_pers':user[6],'tel_lab':user[7],
                'email':user[8],'calle':user[9],'altura':user[10],'piso':user[11],'depto':user[12],'nivel':user[13],'activo':user[14]}
            else:
                content = {}
            return content
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def update_user(self, legajo, dni, nombre, apellido, fecha_nacimiento, fecha_ingreso, telefono_personal, email, nivel, activo, tel_laboral,calle,altura,piso,depto):

        sql2='''UPDATE Empleados as e, Domicilios as d
        SET e.dni = "{}", e.nombre="{}", e.apellido="{}", e.fecha_nacimiento="{}", e.fecha_ingreso = "{}", e.telefono_personal = "{}", e.email="{}",d.calle="{}",d.numero="{}",d.piso="{}",d.depto="{}",
        e.nivel="{}", e.activo={}, e.tel_laboral="{}" 
        WHERE e.legajo = "{}" AND e.id_domicilio = d.id_domicilio '''.format(dni, nombre, apellido, fecha_nacimiento, fecha_ingreso, telefono_personal, email,calle,altura,piso,depto,nivel,activo,tel_laboral,legajo)
        try:
            self.cursor.execute(sql2)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            
            self.connection.close()
    
    def deactivate_user(self, legajo):

        sql2='''UPDATE Empleados as e
        SET e.activo=0 
        WHERE e.legajo = "{}" '''.format(legajo)
        try:
            self.cursor.execute(sql2)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            
            self.connection.close()

    def create_cod_event(self, codigo, descripcion,activo):

        sql2='''INSERT INTO TipoFallas(cod_tipo_falla,desc_falla,activo) VALUES("{}","{}",{})'''.format(codigo, descripcion,activo)
        try:
            self.cursor.execute(sql2)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            
            self.connection.close()

    def get_cod_event(self,codigo):

        sql = '''SELECT cod_tipo_falla,desc_falla,activo FROM TipoFallas WHERE cod_tipo_falla = "{}"'''.format(codigo)

        try:
            self.cursor.execute(sql)
            codigo = self.cursor.fetchone()
            if codigo!=None:
                content = {}
                content = {'codigo':codigo[0],'descripcion':codigo[1],'activo':codigo[2]}
            else:
                content = {}
            return content
        except Exception as e:
            raise
        finally:
            self.connection.close()
    
    def update_cod_event(self, codigo, descripcion, activo):

        sql2='''UPDATE TipoFallas SET desc_falla = "{}",activo={} WHERE  cod_tipo_falla = "{}" '''.format(descripcion,activo,codigo)
        try:
            self.cursor.execute(sql2)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            
            self.connection.close()

    def deactivate_cod_event(self, codigo):

        sql2='''UPDATE TipoFallas as e
        SET e.activo=0 
        WHERE e.cod_tipo_falla = "{}" '''.format(codigo)
        try:
            self.cursor.execute(sql2)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            
            self.connection.close()
    
    #codigos de tareas o de reparacion

    def create_cod_rep(self, codigo, descripcion,activo):

        sql2='''INSERT INTO CodigosResolucion(cod_resolucion,desc_codigo,activo) VALUES("{}","{}",{})'''.format(codigo, descripcion,activo)
        try:
            self.cursor.execute(sql2)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            
            self.connection.close()

    def get_cod_rep(self,codigo):

        sql = '''SELECT cod_resolucion,desc_codigo,activo FROM CodigosResolucion WHERE cod_resolucion = "{}"'''.format(codigo)

        try:
            self.cursor.execute(sql)
            codigo = self.cursor.fetchone()
            if codigo!=None:
                content = {}
                content = {'codigo':codigo[0],'descripcion':codigo[1],'activo':codigo[2]}
            else:
                content = {}
            return content
        except Exception as e:
            raise
        finally:
            self.connection.close()
    
    def update_cod_rep(self, codigo, descripcion, activo):

        sql2='''UPDATE CodigosResolucion SET desc_codigo = "{}",activo={} WHERE  cod_resolucion = "{}" '''.format(descripcion,activo,codigo)
        try:
            self.cursor.execute(sql2)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            
            self.connection.close()

    def deactivate_cod_rep(self, codigo):

        sql2='''UPDATE CodigosResolucion as e
        SET e.activo=0 
        WHERE e.cod_resolucion = "{}" '''.format(codigo)
        try:
            self.cursor.execute(sql2)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            
            self.connection.close()

    def olvidaClave(self,legajo):

        sql = '''SELECT dni FROM Empleados WHERE legajo="{}"'''.format(legajo)
        self.cursor.execute(sql)
        consulta = self.cursor.fetchone()
        if consulta!=None:
            clave = consulta[0]
            sql2='''UPDATE Empleados SET contrasenia = "{}" WHERE legajo="{}" '''.format(clave,legajo)
            try:
                self.cursor.execute(sql2)
                self.connection.commit()
            except Exception as e:
                raise
            finally:
                self.connection.close()
                
        else:
            return False
            
            



    



        
    


        
            

    
    
    











    