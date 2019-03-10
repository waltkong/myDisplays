from .BaseController import controllers
from flask import render_template, request, jsonify, session, json
from app.validators.UserValidator import UserValidator
from app.models.UserModel import UserModel
from app.logics.UserLogic import UserLogic

"""
用户控制器 不需要构造类，直接是函数
request 必须由视图函数触发 注意上下文环境
"""

"""
用户登录页面
"""
@controllers.route('/user/login', methods=['GET'])
def login():
    return render_template('user/login.html')

"""
用户登录
"""
@controllers.route('/user/doLogin', methods=['POST'])
def doLogin():
    validateRes = UserValidator().loginValidate(request.args)
    if validateRes['status'] != 1:
        return jsonify(validateRes)
    data = validateRes['data']
    modelRes = UserModel().doLogin(data)
    if modelRes['status'] == 1:
        UserLogic().createSession()
    return jsonify(modelRes)

"""
用户注册页面
"""
@controllers.route('/user/register', methods=['GET'])
def register():
    return render_template('user/register.html')

"""
用户注册
"""
@controllers.route('/user/doRegister', methods=['POST'])
def doRegister():
    validateRes = UserValidator().registerValidate(request.args)
    if validateRes['status'] != 1:
        return jsonify(validateRes)
    data = validateRes['data']
    modelRes = UserModel().doRegister(data)
    if modelRes['status'] == 1:
        UserLogic().createSession()
    return jsonify(modelRes)

"""
用户添加
"""
@controllers.route('/user/add', methods=['GET'])
def userAdd():
    return render_template('user/add.html')

"""
用户添加提交
"""
@controllers.route('/user/doAdd', methods=['POST'])
def doUserAdd():
    validateRes = UserValidator().userAdd(request.args)
    if validateRes['status'] != 1:
        return jsonify(validateRes)
    data = validateRes['data']
    modelRes = UserModel().add(data)
    return jsonify(modelRes)

"""
用户编辑页面
"""
@controllers.route('/user/edit', methods=['GET'])
def userEdit():
    validateRes = UserValidator().userInfo(request.args)
    if validateRes['status'] != 1:
        return jsonify(validateRes)
    data = validateRes['data']
    modelRes = UserModel().info(data)
    if modelRes['status'] == 1:
        return render_template('user/edit.html', data=modelRes['data'])

"""
用户编辑提交
"""
@controllers.route('/user/doEdit', methods=['POST'])
def doUserEdit():
    validateRes = UserValidator().userEdit(request.args)
    if validateRes['status'] != 1:
        return jsonify(validateRes)
    data = validateRes['data']
    modelRes = UserModel().edit(data)
    return jsonify(modelRes)

"""
用户列表页
"""
@controllers.route('/user/list', methods=['GET'])
def userList():
    req = request.args
    modelRes = UserModel().list(req)
    return jsonify(modelRes['rows'])
    return render_template('user/list.html', data=modelRes)

"""
用户删除
"""
@controllers.route('/user/doDelete', methods=['POST'])
def doUserDelete():
    validateRes = UserValidator().userEdit(request.args)
    if validateRes['status'] != 1:
        return jsonify(validateRes)
    data = validateRes['data']
    modelRes = UserModel().edit(data)
    return jsonify(modelRes)






