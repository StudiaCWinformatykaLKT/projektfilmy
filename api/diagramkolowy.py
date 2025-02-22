import matplotlib.pyplot as plt

labels =[
    "Akcja",
    "Przygodowy",
    "Animacja",
    "Biograficzny"
]


sizes = [10,30,40,20]

plt.pie(sizes, labels=labels, autopct='%1.1f%%',startangle=140)

center_circle = plt.Circle((0,0),0.7,fc='white')
fig = plt.gcf()
fig.gca().add_artist(center_circle)

plt.axis ('equal')
plt.title('Donut diagram')
plt.show()
plt.savefig('diagram_kolowy.png', dpi=300)