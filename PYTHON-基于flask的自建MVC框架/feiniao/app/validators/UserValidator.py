"""
表单验证器 - 用户
"""

class UserValidator(object):

    def loginValidate(self, data):
        if 'user_name' not in data and len(data['user_name']) < 3:
            return {
                'status': -1, 'msg': '用户名必要且长度不小于3'
            }
        return {
            'status': 1, 'msg': '验证通过', 'data': data
        }
    def registerValidate(self, data):
        if 'user_name' not in data and len(data['user_name']) < 3:
            return {
                'status': -1, 'msg': '用户名必要且长度不小于3'
            }
        if 'phone' not in data and len(data['phone']) < 3:
            return {
                'status': -1, 'msg': '手机必要且长度不小于3'
            }
        if 'password' not in data and len(data['password']) < 3:
            return {
                'status': -1, 'msg': '密码必要且长度不小于3'
            }
        return {
            'status': 1, 'msg': '验证通过', 'data': data
        }

    def userAdd(self, data):
        if 'user_name' not in data and len(data['user_name']) < 3:
            return {
                'status': -1, 'msg': '用户名必要且长度不小于3'
            }
        return {
            'status': 1, 'msg': '验证通过', 'data': data
        }

    def userInfo(self, data):
        if 'id' not in data:
            return {
                'status': -1, 'msg': '主键必要'
            }
        return {
            'status': 1, 'msg': '验证通过', 'data': data
        }
    def userEdit(self,data):
        if 'id' not in data:
            return {
                'status': -1, 'msg': '主键必要'
            }
        if 'user_name' not in data and len(data['user_name']) < 3:
            return {
                'status': -1, 'msg': '用户名必要且长度不小于3'
            }
        return {
            'status': 1, 'msg': '验证通过', 'data': data
        }

