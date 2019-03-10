from app.models.UserModel import UserModel
from flask import session

"""
逻辑层 - 用户
"""

class UserLogic(object):

    def createSession(self):
        session['user_name'] = UserModel.this_row.user_name
        session['user_id'] = UserModel.this_row.id
        session['is_super'] = UserModel.this_row.is_super


