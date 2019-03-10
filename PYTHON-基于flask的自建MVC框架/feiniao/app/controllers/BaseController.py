"""
基类控制器注册蓝图
"""
from flask import Blueprint

controllers = Blueprint('controllers', __name__)   #__name__ 指的是controllers蓝图所代表的模块
