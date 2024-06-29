import pymysql
import matplotlib.pyplot as plt
from textblob import TextBlob

host = 'localhost'
port = 3306  # MySQL default port for TCP/IP connections
user = 'root'
password = ''
database = 'mentor'

# Connect to MySQL using TCP/IP
connection = pymysql.connect(
    host=host,
    port=port,
    user=user,
    password=password,
    database=database
)

# Fetch feedback data
def fetch_feedback():
    with connection.cursor() as cursor:
        sql = "SELECT cleanliness, bus_facility, teaching_staff, campus, other FROM student_feedback"
        cursor.execute(sql)
        result = cursor.fetchall()
    return result

# Perform sentiment analysis
def perform_sentiment_analysis(feedback_list):
    sentiments = {}
    for feedback in feedback_list:
        for column_name, feedback_text in feedback.items():
            if column_name not in sentiments:
                sentiments[column_name] = []
            blob = TextBlob(str(feedback_text))  # Convert to string in case of None values
            sentiment = blob.sentiment.polarity
            sentiments[column_name].append(sentiment)
    return sentiments

# Generate sentiment histograms and save as image files
def generate_sentiment_histograms(sentiments):
    for column_name, values in sentiments.items():
        plt.figure()
        plt.hist(values, bins=20, edgecolor='black')
        plt.title(f'Sentiment Analysis of {column_name}')
        plt.xlabel('Sentiment Polarity')
        plt.ylabel('Frequency')
        plt.savefig(f'../static/{column_name}_sentiment_histogram.png')  # Save plot as image
        plt.close()

# Main function
def main():
    feedback_list = fetch_feedback()
    sentiments = perform_sentiment_analysis(feedback_list)
    generate_sentiment_histograms(sentiments)

if __name__ == "__main__":
    main()
