from sklearn.datasets import load_iris
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.neighbors import KNeighborsClassifier
#保存树的结构到dot文件
from sklearn.tree import DecisionTreeClassifier, export_graphviz
"""
KNN k值近邻算法
如果一个样本在特征空间中的k个最相似的样本中的大多数属于某一个类别，则该样本也属于这个类别
如何确定谁是邻居  距离公式： 欧氏距离 曼哈顿距离 【之前要做无量纲化：归一化】
样本不均衡时 k取的过大容易分错 ； k过小会受到异常值的影响
"""

def knn_iris():
    """
    knn对鸢尾花进行分类
    获取数据 划分数据集 特征工程【标准化】 knn算法预估器 模型评估
    :return:
    """
    iris = load_iris()
    x_train, x_test, y_train, y_test = train_test_split(iris.data, iris.target, random_state=6)
    transfer = StandardScaler()
    x_train = transfer.fit_transform(x_train)
    x_test = transfer.transform(x_test)
    estimator = KNeighborsClassifier(n_neighbors=3)
    estimator.fit(x_train, y_train)
    y_predict = estimator.predict(x_test)
    print("y_predict \n", y_predict)
    print("直接对比真实值和预测值 \n", y_test == y_predict)
    score = estimator.score(x_test, y_test)
    print("准确率 \n", score)


"""
朴素贝叶斯算法
朴素：假设特征与特征之间相互独立
"""

"""
决策树  -》适合数据量大
高效的决策 先看哪个特征 能更好的进行筛选
N个样本随机有放回抽取M个特征

"""

"""
信息论基础
消除不确定的东西
信息熵：消除不确定性的信息的多少
比如结果是是否贷款 1/3 代 2/3不待，则可先求出总的信息熵，这个是最开始什么信息都不知道的信息熵结果。 然后根据年龄，找到年龄确定之后的信息熵是多少

信息增益 =  总的信息熵 - 知道某一特征后信息熵  的差值
哪种信息增益最大，也就是减少的最多，则这个特征是最具有代表的特征

"""
def decision_tree_iris():
    """
    决策树对鸢尾花数据进行分类
    1 获取数据集-
    2（数据处理忽略，这特征已经很好，不需要做标准化）划分数据集
    3 决策树预估器进行分类
    4模型评估
    :return:
    """
    iris = load_iris()
    x_train, x_test, y_train, y_test = train_test_split(iris.data,iris.target,random_state=22)
    estimator = DecisionTreeClassifier(criterion="entropy")  # 信息增益
    estimator.fit(x_train, y_train)
    #模型评估
    y_predict = estimator.predict(x_test)
    print("y_predict \n", y_predict)
    print("直接对比真实值和预测值 \n", y_test == y_predict)
    score = estimator.score(x_test, y_test)
    print("准确率 \n", score)

    #可视化决策树
    export_graphviz(estimator, out_file="iris_tree.dot",feature_names=iris.feature_names)


"""
随机森林 是集成学习方法的一种
什么是集成学习方法：通过建立几个模型组合来解决单一预测问题 他的工作原理是生成多个分类器/模型，各自独立学习做出预测，最终结果取众数

"""



if __name__ == "__main__":
    decision_tree_iris()


