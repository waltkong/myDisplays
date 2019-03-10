from sqlalchemy import Column, Integer, String, SmallInteger
from app.models.BaseModel import BaseModel

"""
角色-用户 关联模型
"""
class RoleUserModel(BaseModel):
    __tablename__ = 'role_user'

    id = Column(Integer, primary_key=True, autoincrement=True)
    role_id = Column(Integer)
    user_id = Column(Integer)


