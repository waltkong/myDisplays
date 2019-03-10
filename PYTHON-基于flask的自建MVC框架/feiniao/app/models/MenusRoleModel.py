from sqlalchemy import Column, Integer, String, SmallInteger
from app.models.BaseModel import BaseModel

"""
菜单-角色关联模型
"""
class MenusModel(BaseModel):
    __tablename__ = 'menus_role'
    id = Column(Integer, primary_key=True, autoincrement=True)
    role_id = Column(Integer)
    menu_id = Column(Integer)





