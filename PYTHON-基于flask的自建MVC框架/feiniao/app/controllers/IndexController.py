from .BaseController import controllers
from flask import render_template, request, jsonify, session

"""
后台主页
"""
@controllers.route('/index/index', methods=['GET'])
def adminIndex():
    return render_template('index/index.html')

"""
后台欢迎页面
"""
@controllers.route('/index/welcome', methods=['GET'])
def welcome():
    return render_template('index/welcome.html')



