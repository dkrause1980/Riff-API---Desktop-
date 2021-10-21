import pymysql
from datetime import datetime
import hashlib


class DataBase:
    def __init__(self):
        self.connection = pymysql.connect(
            host = 'localhost',
            user = 'root',
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
                
                content = {'legajo':empleado[0],'nombre':empleado[2],'contrasenia':empleado[9],'nivel':empleado[10]}
            else:
                content = {}
            return content
        except Exception as e:
            raise
        finally:
            self.connection.close()
    
        
    def change_pass(self,contrasenia,legajo):

        sql = 'UPDATE Empleados SET contrasenia={} WHERE legajo={}'.format(contrasenia,legajo)
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

        sql = 'SELECT id_tipo_falla,cod_tipo_falla, desc_falla FROM TipoFallas'

        try:
            self.cursor.execute(sql)
            codigos = self.cursor.fetchall()
            if codigos!=None:
                payload = []
                content = {}
                for res in codigos:
                    content = {'id_tipo_falla':res[0],'codigo':res[1],'descripcion':res[2]}
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

        sql = 'INSERT INTO Eventos(comentario,fecha_creacion,id_tipo_falla,latitud,longitud,legajo_tecnico,id_estado,calle,numero,piso,depto,cod_postal) values ("{}","{}",{},{},{},"{}",1,"{}","{}","{}","{}","2300")'.format(comentario,fecha_creacion,id_tipo_falla,latitud,longitud,legajo_tecnico,calle,numero,piso,depto)
       
        try:
            self.cursor.execute(sql)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            self.connection.close()

    def insert_tipo_falla(self,cod_falla,desc_falla):
        sql = 'INSERT INTO TipoFallas(cod_tipo_falla,desc_falla) values ("{}","{}")'.format(cod_falla,desc_falla)

        try:
            self.cursor.execute(sql)
            self.connection.commit()
        except Exception as e:
            raise
        finally:
            self.connection.close()

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
    
    











    