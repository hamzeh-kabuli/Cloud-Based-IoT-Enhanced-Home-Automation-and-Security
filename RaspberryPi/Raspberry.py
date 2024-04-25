import cv2
import threading
from datetime import datetime
import serial
import time
import json
import requests
from datetime import datetime, timedelta

motion_detected_frames = []

def detect_motion(frame1, frame2, threshold=500):
    gray1 = cv2.cvtColor(frame1, cv2.COLOR_BGR2GRAY)
    gray2 = cv2.cvtColor(frame2, cv2.COLOR_BGR2GRAY)
    diff = cv2.absdiff(gray1, gray2)
    _, thresh = cv2.threshold(diff, 25, 255, cv2.THRESH_BINARY)
    contours, _ = cv2.findContours(thresh, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    motion_pixels = 0
    for contour in contours:
        motion_pixels += cv2.contourArea(contour)
    if motion_pixels > threshold:
        return True
    return False

def put_timestamp(frame):
    current_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    font = cv2.FONT_HERSHEY_SIMPLEX
    text_size = cv2.getTextSize(current_time, font, 0.5, 1)[0]
    text_x = frame.shape[1] - text_size[0] - 10  # Adjusted for top right corner
    cv2.putText(frame, current_time, (text_x, 30), font, 0.5, (255, 255, 255), 1, cv2.LINE_AA)

def capture_and_detect():
    cap = cv2.VideoCapture(0)
    fps = int(cap.get(cv2.CAP_PROP_FPS))
    ret, frame1 = cap.read()
    frame_count = 0
    last_motion_frame = -fps * 5
    start_time = datetime.now()
    count =0
    out_full = cv2.VideoWriter('/home/pi/ClssIOT/full_output.avi', cv2.VideoWriter_fourcc(*'XVID'), fps, (int(cap.get(3)), int(cap.get(4))))  
    while frame_count < 30 * fps:
        
        ret, frame2 = cap.read()
        if not ret:
            break
        #put_timestamp(frame2)
        if detect_motion(frame1, frame2, 10000) and frame_count - last_motion_frame > 5 * fps:
            motion_detected_frames.append(frame_count)
            last_motion_frame = frame_count
            current_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            print(f"Motion detected at: {current_time}")
        out_full.write(frame2)
        frame1 = frame2.copy()
        frame_count += 1
    
    cap.release()
    out_full.release()

def save_motion_segments():
    cap = cv2.VideoCapture('/home/pi/ClssIOT/full_output.avi')
    fps = int(cap.get(cv2.CAP_PROP_FPS))
    
    for idx, frame_number in enumerate(motion_detected_frames):
        start_frame = max(0, frame_number - 5 * fps)
        end_frame = min(frame_number + 5 * fps, int(cap.get(cv2.CAP_PROP_FRAME_COUNT)))
        cap.set(cv2.CAP_PROP_POS_FRAMES, start_frame)
        
        out_segment = cv2.VideoWriter(f'segment_{idx+1}.avi', cv2.VideoWriter_fourcc(*'XVID'), fps, (int(cap.get(3)), int(cap.get(4))))
        
        while cap.get(cv2.CAP_PROP_POS_FRAMES) < end_frame:
            ret, frame = cap.read()
            if not ret:
                break
            put_timestamp(frame)
            out_segment.write(frame)
        
        out_segment.release()
    cap.release()
#/////////////////////////////////////////////////


# Set up the serial connection
ser = serial.Serial('/dev/ttyACM0', 9600, timeout=1)
ser.flush()

def get_full_message(ser):
    full_message = ""
    line = ""
    # Wait for a short period to collect data
    timeout_start = time.time()
    timeout = 0.5  # 500 milliseconds timeout to wait for additional data
    
    while True:
        if ser.in_waiting > 0:
            line = ser.readline().decode('utf-8').rstrip()
            full_message += line + "\n"  # Append new line for readability
            timeout_start = time.time()  # Reset timeout start on new data
            #print(full_message)
        if time.time() - timeout_start > timeout:
            break  # Exit loop if no new data within the timeout period
    
    return full_message.strip()
#///////////////////////////////////////////////
def send_data_to_arduino(controls):

    timeout_start = time.time()
    timeout = 0.5  # 500 milliseconds timeout
    print('my controls')
    print(controls)
    while True:
        if ser.in_waiting > 0:
            
            line = controls[:4]
            print(f"{line}")
            # line = ser.readline().decode('utf-8').rstrip()
            if line == "POST":
                # Sending data when "POST" is detected
                # ser.write(('fan: ' + str(fan) + '\n').encode('utf-8'))
                # ser.write(('buzzer: ' + str(buzzer) + '\n').encode('utf-8'))
                # ser.write(('light: ' + str(light) + '\n').encode('utf-8'))
                print(controls)
                ser.write(controls.encode('utf-8') + b'\n')
                
                timeout_start = time.time()  # Reset timeout start on data send
                

        if time.time() - timeout_start > timeout:
            break  # Exit loop if no new data within the timeout period

        time.sleep(0.1)  # Short delay to prevent spamming
def parse_data(full_message):
    data = {}
    parts = full_message.split(",")
    #print("from parsdata",full_message)
    for part in parts:
        if ":" in part:
            key, value = part.split(":")
            value = value.strip()
            if "Status" in key:  # For Fan_Status or any other _Status
                value = 1 if "ON" in value.upper() else 0
            data[key.strip().replace(" ", "_").lower()] = value
    return data

def create_json_payload(data):
    
    payload = {
        "temperature": data.get("temperature", "0"),
        "humidity": data.get("humidity", "0"),
        "light_intensity": data.get("light_measure", "0"),
        "lights": data.get("light_status", 0),  # Assuming you might add light status too
        "fan": data.get("fan_status", 0),
        "motion": 0,  # Example static value
        "buzzer": 0,  # Example 
    }
    return payload

def send_current_state(json_payload):
    url = "https://iot.khalilrahimy.com/raspberry/save"
    file_path = "/home/pi/ClssIOT/full_output.avi"
    files = {'video': open(file_path, 'rb')}
    
    
    try:
        response = requests.post(url, files=files, data=json_payload)
        response.raise_for_status()
        # Optionally get the latest state after sending
        get_latest_state()
    except requests.exceptions.HTTPError as http_err:
        print(f"HTTP error occurred: {http_err}")
    except Exception as err:
        print(f"An error occurred: {err}")

def get_latest_state():
    url = "https://iot.khalilrahimy.com/api/app/current-state"
    try:
        response = requests.get(url)
        response.raise_for_status()
        print("Latest state of the environment:", response.json())
    except requests.exceptions.HTTPError as http_err:
        print(f"HTTP error occurred: {http_err}")
    except Exception as err:
        print(f"An error occurred: {err}")

def get_controls():
    url = "https://iot.khalilrahimy.com/api/raspberry/switch"
    try:
        response = requests.get(url)
        response.raise_for_status()
        
        return response.text
            
        print("Latest state of the environment:", response.json())
    except requests.exceptions.HTTPError as http_err:
        print(f"HTTP error occurred: {http_err}")
    except Exception as err:
        print(f"An error occurred: {err}")

def Get_From_Arduino():
    ser.write(b"GET\n")
    full_message = get_full_message(ser)
    #print("Received:", full_message)  # For debugging
    
    if full_message:
        data = parse_data(full_message)
        json_payload = create_json_payload(data)
        print("JSON payload:", json_payload)
        # Send json_payload to a cloud service
        send_current_state(json_payload)
    else:
        print("No data received. Check the Arduino connection.")

#///////////////////////////////////////////////
Get_From_Arduino()
time.sleep(10)
while True:
    control_string = get_controls()
    print('just befor sending to arduino')
    print(f"cccc = {control_string}")
    time.sleep(1)
    send_data_to_arduino(control_string)
    Get_From_Arduino()
    thread_capture_detect = threading.Thread(target=capture_and_detect)
    thread_capture_detect.start()
    thread_capture_detect.join()
    save_motion_segments()
    print("Processing completed.")
    time.sleep(0.1)
    
