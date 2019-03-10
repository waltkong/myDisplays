from sqlalchemy import Column, Integer, String, SmallInteger
from app.models.BaseModel import BaseModel
import time
import hashlib
"""
用户模型
"""
class UserModel(BaseModel):
    __tablename__ = 'user'

    id = Column(Integer, primary_key=True, autoincrement=True)
    user_name = Column(String(50), nullable=False)
    password = Column(String(255), nullable=False)
    phone = Column(String(255), nullable=False)
    is_super = Column(SmallInteger)

    this_row = {}   # 保存当前数据  静态调用
    time = int(time.time())

    def __str__(self):
        return 'UserModel{user_name=%s,phone=%s,password=%s,}' % (self.user_name, self.phone, self.password,)


    def doRegister(self, data):
        user1 = UserModel.query.filter('user_name' == data['user_name']).first()
        if user1:
            return {'status': -1, 'msg': ' 已经有该用户'}
        user2 = UserModel.query.filter('phone' == data['phone']).first()
        if user2:
            return {'status': -1, 'msg': ' 已经有该手机'}
        u = UserModel()
        u.user_name = data['user_name']
        u.password = self.encodePassword(data['password'])
        u.phone = data['phone']
        u.is_super = 1 if data['user_name'] == 'admin' else 0
        u.add_time = time
        u.update_time = time
        BaseModel.db_instance.session.add(u)
        BaseModel.db_instance.session.commit()
        UserModel.this_row = user1
        return {'status': 1, 'msg': ' 注册成功'}

    def encodePassword(self, data):
        return hashlib.md5(data.encode(encoding='UTF-8')).hexdigest()

    def doLogin(self, data):
        user1 = UserModel.query.filter('user_name' == data['user_name']).first()
        if user1:
            if self.encodePassword(data['password']) != user1.password:
                return {'status': -1, 'msg': ' 密码错误'}
            else:
                UserModel.this_row = user1
                return {'status': 1, 'msg': ' 登录成功'}
        else:
            return {'status': -1, 'msg': ' 找不到该用户'}


    def add(self,data):
        user1 = UserModel.query.filter('user_name' == data['user_name']).first()
        if user1:
            return {'status': -1, 'msg': ' 已经有该用户'}
        user2 = UserModel.query.filter('phone' == data['phone']).first()
        if user2:
            return {'status': -1, 'msg': ' 已经有该手机'}
        u = UserModel()
        u.user_name = data['user_name']
        u.password = self.encodePassword(data['password'])
        u.phone = data['phone']
        u.is_super = 1 if data['user_name'] == 'admin' else 0
        u.add_time = time
        u.update_time = time
        BaseModel.db_instance.session.add(u)
        BaseModel.db_instance.session.commit()
        return {'status': 1, 'msg': ' 添加成功'}

    def edit(self,data):
        user1 = UserModel.query.filter('id' == data['id']).first()
        if user1:
            #将密码从字典删除
            data.pop('password')
            for key, value in data.items():
                user1[key] = value
            user1.update_time = time
            BaseModel.db_instance.session.commit()
            return {'status': 1, 'msg': ' 编辑成功'}
        else:
            return {'status': -1, 'msg': ' 用户不存在'}

    def info(self, data):
        user1 = UserModel.query.filter('id' == data['id']).first()
        if user1:
            return {'status': 1, 'msg': ' 编辑成功', 'data': user1}
        else:
            return {'status': -1, 'msg': ' 用户不存在'}

    def list(self, data):
        page_index = data['page_index'] if 'page_index' in data else 1
        each_page = data['each_page'] if 'each_page' in data else 5
        queryset = UserModel.query.order_by('id')
        print(333)
        queryRes = queryset.paginate(page_index, each_page, False)   # page_index,each_page,False 每页each_page个，查询第page_index页
        return {
            'rows': queryRes.items,         # 查询数据
            'page_index': queryRes.page,    # 当前页
            'total_index': queryRes.pages,  # 总页数
        }

    def delete(self, data):
        user1 = UserModel.query.filter('id' == data['id']).first()
        if user1:
            BaseModel.db_instance.session.delete(user1)
            BaseModel.db_instance.session.commit()
            return {'status': 1, 'msg': ' 删除成功'}
        else:
            return {'status': -1, 'msg': ' 用户不存在'}


