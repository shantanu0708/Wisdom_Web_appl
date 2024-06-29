import pymysql
import matplotlib.pyplot as plt
import io
import base64

def fetch_data_from_database():
    connection = pymysql.connect(host='localhost:3306',
                                 user='root',
                                 password='',
                                 db='mentor',
                                 charset='utf8mb4',
                                 cursorclass=pymysql.cursors.DictCursor)
    try:
        with connection.cursor() as cursor:
            # Fetch data from the database
            cursor.execute("SELECT * FROM student_feed")
            data = cursor.fetchall()
    finally:
        connection.close()
    return data

def generate_graph(data):
    # Process the data and generate the graph
    x = [row['x_column'] for row in data]
    y = [row['y_column'] for row in data]

    plt.plot(x, y)
    plt.xlabel('X Axis')
    plt.ylabel('Y Axis')
    plt.title('Graph Title')
    
    # Save the plot to a BytesIO object
    img = io.BytesIO()
    plt.savefig(img, format='png')
    img.seek(0)
    plt.close()
    
    # Encode the image to base64
    graph_url = base64.b64encode(img.getvalue()).decode()
    return 'data:image/png;base64,{}'.format(graph_url)

if __name__ == '__main__':
    # Fetch data from the database
    data = fetch_data_from_database()
    
    # Generate the graph
    graph = generate_graph(data)
    
    # Write the base64 encoded image data to a text file
    with open('graph_data.txt', 'w') as f:
        f.write(graph)
