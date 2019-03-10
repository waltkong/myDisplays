from sklearn.datasets import load_iris
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction import DictVectorizer
from sklearn.feature_extraction.text import CountVectorizer,TfidfVectorizer
import pandas as pd
from sklearn.preprocessing import MinMaxScaler, StandardScaler
from sklearn.feature_selection import VarianceThreshold
#皮尔森相关系数
from scipy.stats import pearsonr
from sklearn.decomposition import PCA


"""
数据和特征决定了机器学习的上限，而模型和算法只是逼近这个上限而已
特征工程 用sklearn  而pandas做数据清洗，比如缺失值
"""


def datasets_demo():
    """
    sklearn数据集使用
    1 获取数据集
    :return:
    """
    iris = load_iris()
    # print("鸢尾花数据集：\n", iris)
    # print("数据集描述:\n", iris["DESCR"])
    print("特征值的名字:\n", iris.feature_names)
    print("特征值:\n", iris.data, iris.data.shape)

    #数据集划分
    x_train, x_test, y_train, y_test = train_test_split(iris.data, iris.target, test_size=0.2, random_state=22)
    print("训练集的特征值：\n", x_train, x_train.shape)


def dict_demo():
    """
    字典特征抽取
    :return:
    """
    data = [{"city": "beijing", "temperature": 108},
            {"city": "shanghai", "temperature": 34},
            {"city": "guangzhou", "temperature": 56}]
    #实例化一个转换器类 。 调用 fit_transform()
    transfer = DictVectorizer(sparse=False)
    data_new = transfer.fit_transform(data)
    print("data_new\n", data_new)
    print("特征名字\n", transfer.get_feature_names())

def count_demo():
    """
    文本特征抽取
    :return:
    """
    data = ["life is short , i like python and i like php . life is too long , i hate python "]
    transfer = CountVectorizer()
    data_new = transfer.fit_transform(data)
    print("data_new\n", data_new.toarray())
    print("特征名字\n", transfer.get_feature_names())

def count_demo_chinese():
    """
    文本特征抽取
    要 借助 结巴分词 进行中文分词
    :return:
    """
    data = ["我 爱 北京 天安门，天安门 上 太阳 升"]
    transfer = CountVectorizer()
    data_new = transfer.fit_transform(data)
    print("data_new\n", data_new.toarray())
    print("特征名字\n", transfer.get_feature_names())

def tfidf_demo():
    """
    关键词：在某一类中出现次数很多，在其他类中出现次数很少
    TF-IDF作用：评估字词对于一个文件集的其中一份文件的重要程度
    值越大 表示越重要  越代表有分类意义
    :return:
    """
    data = ["life is short , i like python and i like php . life is too long , i hate python "]
    transfer = TfidfVectorizer()
    data_new = transfer.fit_transform(data)
    print("data_new\n", data_new.toarray())
    print("特征名字\n", transfer.get_feature_names())

def minmax_demo():
    """
    归一化
    获取数据 实例化转换器类 调用 fit_transform
    :return:
    """
    data = pd.read_csv("dating.txt")
    data = data.iloc[:, :3]
    transfer = MinMaxScaler()
    data_new = transfer.fit_transform(data)
    print("data_new\n", data_new.toarray())

def standalize_demo():
    """
    标准化 对原始数据进行变换 把数据变化到均值为0，标准差为1的范围内
    X' = (x - mean) / δ   作用于每一列 mean为平均值 δ为标准差
    :return:
    """
    data = pd.read_csv("dating.txt")
    data = data.iloc[:, :3]
    transfer = StandardScaler()
    data_new = transfer.fit_transform(data)
    print("data_new\n", data_new.toarray())


"""
特征选择
FILTER过滤式  
    1分方差选择法：低方差特征过滤  删除低方差特征 
    2相关系数
embedded嵌入式
    1决策树
    2正则化
    3深度学习：卷积等
    
相关系数 表示两个变量之间的关系是不是很强
"""

def variance_demo():
    """
    过滤低方差特征
    :return:
    """
    data = pd.read_csv("dating.csv")
    transfer = VarianceThreshold(threshold=5)
    data_new = transfer.fit_transform(data)
    print("data_new\n", data_new, data_new.shape)

def pearson_relationship(data):
    """
    皮尔逊相关系数   越接近1表示越相关
    如果相关性高，则选择其中1个 或者等权重 形成一个新的特征  或者主成分分析
    :return:
    """
    r = pearsonr(data["pe_ration"], data["pb_ratio"])
    print(r)


"""
什么是主成分分析
高纬度数据转化为低维度数据的过程 此过程可能会舍去原有的数据，创造新的变量
作用：将数据维度压缩，尽可能降低数据的维度【复杂度】，损失少量信息
应用：回归分析或者聚类分析

pca降维：找到一条合适的直线，通过一个矩阵运算得出主成分分析的结果 
"""


def pca_demo():
    """
    pca降维
    :return:
    """
    data = [[2, 8, 3, 5], [6, 3, 0, 8], [5, 4, 9, 1]]
    transfer = PCA(n_components=0.95)
    data_new = transfer.fit_transform(data)
    print("data_new\n", data_new, data_new.shape)

"""
案例-探究用户对物品的喜好
1用户和物品放在一张表中 pd.merge(data1,data2,on=['aid','aid'])
2交叉表和透视表
3大量的0 特征冗余过多 需要降维 所以主成分分析
"""


"""
转换器  特征工程的父类  先实例化 然后 fit_transform
和
预估器estimator  
实例化estimator 然后estimator.fit(x_train,y_train) 训练（计算）,生成模型   y_predict = estimator.predict(x_test)
y_test == y_predict   
计算准确率  estimator.score(x_test,y_test)
"""





if __name__ == "__main__":
    pca_demo()

