from sqlalchemy import Column, Integer, String, SmallInteger
from app.models.BaseModel import BaseModel

"""
角色模型
"""
class RoleModel(BaseModel):
    __tablename__ = 'role'

    id = Column(Integer, primary_key=True, autoincrement=True)
    role_name = Column(String(50), nullable=False)
    role_comment = Column(String(255))



