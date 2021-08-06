import pymysql


class DataBase:
    def __init__(self):
        self.connection = pymysql.connect(
            host = 'localhost',
            user = 'root',
            password = 'root',
            db = 'Riff'
        )

        self.cursor = self.connection.cursor()


    def select_employ(self,legajo):
        sql = 'SELECT * FROM Empleados WHERE legajo = {}'.format(legajo)

        try:
            self.cursor.execute(sql)
            empleado = self.cursor.fetchone()
            if empleado!=None:
                content = {'legajo':empleado[0],'nombre':empleado[2],'contrasenia':empleado[10],'nivel':empleado[4]}
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

        sql = 'SELECT cod_falla, desc_falla FROM TipoFallas'

        try:
            self.cursor.execute(sql)
            codigos = self.cursor.fetchall()
            if codigos!=None:
                payload = []
                content = {}
                for res in codigos:
                    content = {'codigo':res[0],'descripcion':res[1]}
                    payload.append(content)
                    content = {}
            else:
                payload = []
            return payload
        except Exception as e:
            raise
        finally:
            self.connection.close()











    