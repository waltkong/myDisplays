from sqlalchemy import Column, Integer, String, SmallInteger
from app.models.BaseModel import BaseModel

"""
菜单模型
"""
class MenusModel(BaseModel):
    __tablename__ = 'menus'

    id = Column(Integer, primary_key=True, autoincrement=True)
    menu_name = Column(String(50), nullable=False)
    menu_url = Column(String(255), nullable=False)





