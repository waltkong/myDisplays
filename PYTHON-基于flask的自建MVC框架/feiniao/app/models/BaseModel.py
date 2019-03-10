from flask_sqlalchemy import SQLAlchemy
from sqlalchemy import Column, Integer, String, SmallInteger
"""
模型基类 拿到db对象
"""


db = SQLAlchemy()

class BaseModel(db.Model):
    __abstract__ = True

    create_time = Column(Integer)
    update_time = Column(Integer)

    db_instance = db

    def set_attrs(self, attrs):
        for key, value in attrs.items():
            if hasattr(self, key) and key != 'id':
                setattr(self, key, value)

