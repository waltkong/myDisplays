"""
包 初始化代码
"""

from flask import Flask
from app.models.BaseModel import db

"""
创建flask核心对象
"""
def create_app():
    app = Flask(__name__)
    app.config.from_object('config')   ##加载自定义配置文件
    register_blueprint(app)

    db.init_app(app)
    db.create_all(app=app)  #生成数据表  如果不传 app=app 会报application not found
    return app

"""
将蓝图注册到flask核心对象
"""
def register_blueprint(app):
    from app.controllers.BaseController import controllers
    app.register_blueprint(controllers)


