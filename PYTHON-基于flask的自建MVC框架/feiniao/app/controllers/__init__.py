"""
负责蓝图的初始化工作
"""

from flask import Blueprint

# 使得试图层的路由生效

from . import UserController
from . import IndexController
