from flask import Flask,jsonify, request
from db import DataBase
app = Flask(__name__)


@app.route('/')
def index():
    return '<h1>Hola!<h1>'